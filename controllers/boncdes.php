<?php

class boncdesCtrl extends Controller {

	public $smarty;
	public $boncde_entete;
	
	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->boncde_entete = new dbtable('boncde_entete');
		$this->boncde_poste = new dbtable('boncde_poste');
		$this->boncde_poste_mail = new dbtable('boncde_poste_mail');
		$this->client_had = new dbtable('client_had');
		$this->patient_had = new dbtable('patient_had');
		$this->produit_had = new dbtable('produit_had');
		$this->raison_had = new dbtable('raison_had');
		$this->utilisateur = new dbtable('UTILISATEURS');
	}

	public function defaut() {
		$this->liste();
	}

	/**
	 * **************************************************
	 * Affiche la page avec smarty ( Fusion et affichage)
	 * ************************************************** ffichage enregistrement vide pour ajout
	 * *********************************************
	 */
	public function lecture() {

		$element = $this->boncde_entete->emptyRecord();
		$element['sk_client'] = auth::$auth ['sk_client'];
		$element['datdem'] = date('d/m/Y');

		// Lecture enregistrement
		$groupes = $this->boncde_poste->query("select distinct(lb_hierachie) "
				. "from produit_had where sk_client=:sk_client order by lb_classement ", array('sk_client' => auth::$auth ['sk_client']));

		if ($groupes) {

			foreach ($groupes as $k => $groupe) {
				$groupe['produits'] = $this->boncde_poste->query("SELECT lb_produit, sk_produit FROM produit_had WHERE lb_hierachie='" . $groupe['lb_hierachie'] . "' AND sk_client=:sk_client order by lb_classement,lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
				foreach ($groupe['produits'] as $produit) {
					$quantite[$produit['sk_produit']] = 0;
					$commentaire[$produit['sk_produit']] = '';
					$credat[$produit['sk_produit']] = '';
				}
				$groupes[$k] = $groupe;
			}
		}
		$_SESSION['element'] = $element;
		$_SESSION['groupes'] = $groupes;

		$this->smarty->assign('groupes', $groupes);
		$element['quantite'] = $quantite;
		$element['commentaire'] = $commentaire;
		$element['credat'] = $credat;
		
		$this->zones_page($element);
		$this->affiche("form");
	}
	 /*@param string $page_a_afficher        	
	 */
	private function affiche($page_a_afficher) {

		if (empty(auth::$auth['sk_client'])) {
			$client_had['lb_donneur_ordre'] = '<<<<<< Mode administrateur >>>>>>';
		} else {
			$client_had = $this->client_had->find('sk_client', auth::$auth['sk_client']);
		}
		$this->smarty->assign('client_had', $client_had);
		
					
		if ($page_a_afficher == "form") {
			$this->smarty->displayLayout('boncdes/fiche.tpl', 'Bon de commande');
			
		} elseif ($page_a_afficher == "list") {
			$this->smarty->displayLayout('boncdes/liste.tpl', 'Liste des bons de commandes');
		} else {
			echo 'error';
		}
	}

	/**
	 * **********************************************
	 * Fontion AJAX de recup du contenu de datatable
	 * **********************************************
	 */
	public function tableau_json() {

		$r_boncde_entete = $_SESSION ['r_boncde_entete'];

		// CONSTRUCTION DU WHERE
		$wheres = array();

		if (isset($r_boncde_entete['r_statut']) && $r_boncde_entete ['r_statut'] != 'T' && $r_boncde_entete ['r_statut'] != 'H')
			$wheres [] = "B.statut='" . $r_boncde_entete ['r_statut'] . "' AND B.datfinhad='0000-00-00'";
		
		if (isset($r_boncde_entete['r_statut']) && $r_boncde_entete ['r_statut'] == 'T')
			$wheres [] = "B.statut<>'S'";
		
		if (isset($r_boncde_entete['r_statut']) && $r_boncde_entete ['r_statut'] == 'H')
			$wheres [] = "B.datfinhad<>'0000-00-00'";

		if (isset($r_boncde_entete ['r_numcde']) && !empty($r_boncde_entete ['r_numcde']))
			$wheres [] = "numcde='" . sql_escape($r_boncde_entete ['r_numcde']) . "'";
		
		if (isset($r_boncde_entete ['r_numpat']) && !empty($r_boncde_entete ['r_numpat']))
			$wheres [] = "numpat='" . sql_escape($r_boncde_entete ['r_numpat']) . "'";

		if (isset($r_boncde_entete ['r_datdem']) && !empty($r_boncde_entete ['r_datdem']))
			$wheres [] = " datdem = '" . sql_escape(dateverssql($r_boncde_entete ['r_datdem'])) . "'";

		if (isset($r_boncde_entete ['r_datliv']) && !empty($r_boncde_entete ['r_datliv']))
			$wheres [] = " datliv = '" . sql_escape(dateverssql($r_boncde_entete ['r_datliv'])) . "'";

		if (isset($r_boncde_entete ['r_lb_nom']) && !empty($r_boncde_entete ['r_lb_nom']))
			$wheres [] = " TRIM(lb_nom) like '" . sql_escape($r_boncde_entete ['r_lb_nom']) . "%'";

		// Restriction aux boncde_entete
		if (auth::$auth ['grputi'] != "A") {
			$wheres [] = "B.sk_client  = '" . auth::$auth ['sk_client'] . "'";
		}

		// RECUP. DU NOMBRE TOTAL D'ENREG.
		$sqlcount = "SELECT COUNT(*) AS CPT FROM boncde_entete B ";
		$count = $this->boncde_entete->queryFirst($sqlcount);

		// RECUP. DU NOMBRE D'ENREG. FILTRES.
		if (!empty($wheres))
			$countfilter = $this->boncde_entete->queryFirst($sqlcount . " WHERE " . implode(" AND ", $wheres));
		else
			$countfilter = $count;

		// CONSTRUCTION DE LA REQUETE.
		$fields = $this->datatable_columns($_GET);
		$select = implode(" , ", $fields);
		$select = substr_replace($select, '', strpos($select, 'orderStatus'), 13);

		$sql = "SELECT " . $select . " FROM boncde_entete B left join patient_had P ON numpat=P.ext_patient ";
		if (!empty($wheres))
			$sql .= " WHERE " . implode(" AND ", $wheres);
	
		$sql .= $this->datatable_order_offset($_GET, $fields);

		// EXECUTION DE LA REQUETE.
		$elements = $this->boncde_entete->query($sql, PDO::FETCH_NUM);

		// MISE EN FORME DES DONNEES ET AJOUT DES OPTIONS.
		$indcode = array_search('numcde', $fields);
		$inddatdem = array_search('datdem', $fields);
		$inddatliv = array_search('datliv', $fields);
		$inddatenvmail = array_search('datenvmail', $fields);
		$inddatfinhad = array_search('B.datfinhad', $fields);
		$indstatut = array_search('B.statut', $fields);
		$columnOrderStatus = array_search('orderStatus', $fields);

		foreach ($elements as $k => $element) {

			$element[$inddatdem] = datevershtml($element[$inddatdem]);
			$element[$inddatliv] = datevershtml($element[$inddatliv]);
			$element[$inddatenvmail] = datevershtml($element[$inddatenvmail]);
			$element[$inddatfinhad] = datevershtml($element[$inddatfinhad]);
			$element[$columnOrderStatus] = 'Livrée';
			
			$element [] = '<a href="#" onclick="editer(\'' . $element [$indcode] . '\');"><img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier"></a>';
			if ($element[$indstatut] == 'A') { 				
				if ($element[$inddatfinhad]==0)	{
					$element[$indstatut] = 'En cours';
				}else{
					$element[$indstatut] = 'Fin HAD';
				}	
			}else{
				$element[$indstatut] = 'Hospitalisation';
			}
			
			$elements [$k] = $element;
		}

		// RENVOI DU RESULTAT
		$output = array(
			"draw" => $_GET ['draw'],
			"recordsTotal" => $count ['CPT'],
			"recordsFiltered" => $countfilter ['CPT'],
			"data" => $elements
		);
		echo json_encode($output);
	}

	/**
	 * **********************************************
	 * Affichage table des bons de commandes
	 * **********************************************
	 */
	public function liste($rp_numcde = '', $rp_datdem = '', $rp_datliv = '') {

		// valeur par defaut des recherches
		$r_boncde_entete = array(
			'r_numcde' => '',
			'r_numpat' => '',
			'r_lb_nom' => '',
			'r_datdem' => '',
			'r_datliv' => '',
			'r_statut' => 'T'
		);

		// integration des paramétres
		if ($rp_numcde != '*')
			$_SESSION ['r_boncde_entete']['r_numcde'] = $rp_numcde;

		if ($rp_datdem != '*') {
			$rp_datdem = str_replace('-', '/', $rp_datdem);
			$_SESSION ['r_boncde_entete']['r_datdem'] = $rp_datdem;
		}
		if ($rp_datliv != '*') {
			$rp_datliv = str_replace('-', '/', $rp_datliv);
			$_SESSION ['r_boncde_entete']['r_datliv'] = $rp_datliv;
		}

		if (isset($_SESSION ['r_boncde_entete']))
			$r_boncde_entete = array_copie($r_boncde_entete, $_SESSION ['r_boncde_entete']);
		if (isset($_POST))
			$r_boncde_entete = array_copie($r_boncde_entete, $_POST);
		// sauvegarde en session de la recherche
		$_SESSION ['r_boncde_entete'] = $r_boncde_entete;

		// initialisation des variables ecrans....
		$this->smarty->assign('r_boncde_entete', $r_boncde_entete);
		$this->affiche('list');
	}

	/**
	 * ********************************************
	 * Activer
	 * *********************************************
	 */
	public function activer($numcde) {
		if (isset($numcde)) {
			$this->boncde_entete->update('numcde', $numcde, array(
				'statut' => 'A'
			));
			$raison = 'Retour hospitalisation';
			$this->mailbcdeeve($numcde, $raison, false);
		}
	}

	/**
	 * ********************************************
	 * Desactiver
	 * *********************************************
	 */
	public function desactiver($numcde) {
		if (isset($numcde)) {
			$this->boncde_entete->update('numcde', $numcde, array(
				'statut' => 'D'
			));
			$raison = 'Hospitalisation';
			$this->mailbcdeeve($numcde, $raison, false);
		}
	}
	/**
	 * ********************************************
	 * Suppression
	 * *********************************************
	 */
	public function supprimer($numcde) {
		if (isset($numcde)) {
			$this->boncde_entete->update('numcde', $numcde, array(
				'statut' => 'S'
			));
			$raison = 'Suppression';
			$this->mailbcdeeve($numcde, $raison, false);
		}
	}
	/**
	 * ********************************************
	 * Affichage enregistrement à modifier
	 * *********************************************
	 */
	public function modifier($numcde) {

		if (isset($numcde)) {
			// Lecture enregistrement
			$element = $this->boncde_entete->find('numcde', $numcde);
			// si pas trouve alors on revient sur la liste
			if ($element) {

				$element['datdem'] = datevershtml($element['datdem']);
				$element['datliv'] = datevershtml($element['datliv']);

				// Lecture enregistrement
				$groupes = $this->boncde_poste->query("select distinct(lb_hierachie) "
						. "from produit_had where sk_client=:sk_client order by lb_classement ", array('sk_client' => auth::$auth ['sk_client']));
				$quantite = array();
				$commentaire = array();
				$credat = array();
				if ($groupes) {

					foreach ($groupes as $k => $groupe) {
						$groupe['produits'] = $this->boncde_poste->query("SELECT P.lb_produit, P.sk_produit, B.qt_produit, B.co_produit,DATE_FORMAT( B.credat, '%d/%m/%y' ) AS credat FROM produit_had P LEFT JOIN boncde_poste B ON P.sk_produit = B.sk_produit and numcde='" . $numcde . "' WHERE lb_hierachie='" . $groupe['lb_hierachie'] . "' AND P.sk_client=:sk_client order by P.lb_classement,P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						foreach ($groupe['produits'] as $produit) {
							$quantite[$produit['sk_produit']] = $produit['qt_produit'];
							$commentaire[$produit['sk_produit']] = $produit['co_produit'];
							$credat[$produit['sk_produit']] = $produit['credat'];///ajout date de cr�ation de la ligne produit B.OCHUDLO le 20/11/2015
						}
						$groupes[$k] = $groupe;
					}
				}
				$_SESSION['element'] = $element;
				$_SESSION['groupes'] = $groupes;

				$this->smarty->assign('groupes', $groupes);
				$element['quantite'] = $quantite;
				$element['commentaire'] = $commentaire;
				$element['credat'] = $credat;///ajout date de cr�ation de la ligne produit B.OCHUDLO le 20/11/2015

				$this->zones_page($element);
				$this->affiche('form');
			} else {
				$this->liste();
			}
		}
	}

	/**
	 * ********************************************
	 * Zones page
	 * *********************************************
	 */
	public function zones_page(&$element) {

		$element = array_ajoute($element, $_SESSION['element']);
		$element['hide_numcde'] = $element['numcde'];

		$element['rech_patient_had'] = "";

		if (isset($element['numpat'])) {
			$patient_had = $this->patient_had->find('ext_patient', $element['numpat']);
			if (!$patient_had)
				$patient_had = $this->patient_had->emptyRecord();
		}else {
			$patient_had = $this->patient_had->emptyRecord();
		}
		$this->smarty->assign('patient_had', $patient_had);
		
		$this->smarty->assign('element', $element);
		$this->smarty->assign('groupes', $_SESSION['groupes']);
		$this->smarty->assign('quantite', $element['quantite']);
		$this->smarty->assign('commentaire', $element['commentaire']);
				

	}

	/**
	 * *********************************************
	 * Affichage enregistrement vide pour ajout
	 * *********************************************
	 */
	public function ajouter() {

		$element = $this->boncde_entete->emptyRecord();
		$element['sk_client'] = auth::$auth ['sk_client'];
		$element['datdem'] = date('d/m/Y');

		// Lecture enregistrement
		$groupes = $this->boncde_poste->query("select distinct(lb_hierachie) "
				. "from produit_had where sk_client=:sk_client order by lb_classement ", array('sk_client' => auth::$auth ['sk_client']));

		if ($groupes) {

			foreach ($groupes as $k => $groupe) {
				$groupe['produits'] = $this->boncde_poste->query("SELECT lb_produit, sk_produit FROM produit_had WHERE lb_hierachie='" . $groupe['lb_hierachie'] . "' AND sk_client=:sk_client order by lb_classement,lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
				foreach ($groupe['produits'] as $produit) {
					$quantite[$produit['sk_produit']] = 0;
					$commentaire[$produit['sk_produit']] = '';
					$credat[$produit['sk_produit']] = '';
				}
				$groupes[$k] = $groupe;
			}
		}
		$_SESSION['element'] = $element;
		$_SESSION['groupes'] = $groupes;
		/*B.OCHUDLO le 23/11/2015 On charge les infos patients*/
		if (isset($_GET['numpat'])) {
			$patient_had = $this->patient_had->find('ext_patient', $_GET['numpat']);			
			$element['numpat']=$_GET['numpat'];	
				
			}			
			else {
				$element['numpat'] = "";	
			}			
		
		
		$this->smarty->assign('groupes', $groupes);
		$element['quantite'] = $quantite;
		$element['commentaire'] = $commentaire;
		$element['credat'] = $credat;
		
		$this->zones_page($element);
		$this->affiche("form");	
		
	}

	/**
	 * *********************************************
	 * Enregistrement modification
	 * *********************************************
	 */
	public function enregistrer() {
		/*if (isset($_POST['btn_suivant'])) {
			$this->message('Aper�u commande', 'error');
			$this->zones_page($_POST);
			$this->affiche("form");
			return;
		}*/
		if (isset($_POST['btn_enregistrer'])) {

			$hide_numcde = $_POST ['hide_numcde'];
			$numcde = $_POST ['numcde'];

			// Controle de la saisie
			if (empty($_POST ['numpat'])) {
				$this->message('Vous devez entrer un patient', 'error');
				$this->zones_page($_POST);
				$this->affiche("form");
				return;
			}
			// test date de livraison
			if (empty($_POST ['datliv'])) {
				$this->message('Vous devez entrer une date de livraison', 'error');
				$this->zones_page($_POST);
				$this->affiche("form");
				return;
			}

			// saisie valide -> mise à jour base
			$_POST['datliv'] = dateverssql($_POST['datliv']);
			$_POST['datdem'] = dateverssql($_POST['datdem']);

			if (empty($hide_numcde)) {
				// INSERT
				$prefnum = $this->client_had->queryFirst("SELECT prefixe_num as pref FROM client_had WHERE sk_client=:sk_client", array('sk_client' => auth::$auth ['sk_client']));
				$dernum = $this->boncde_entete->queryFirst("SELECT max(substr(numcde,5,10)) as nummax FROM boncde_entete WHERE sk_client=:sk_client", array('sk_client' => auth::$auth ['sk_client']));

				$_POST['numcde'] = $prefnum['pref'] . '_' . sprintf("%1$010d", ($dernum['nummax'] + 1));
				$_POST['sk_client'] = auth::$auth ['sk_client'];

				$this->boncde_entete->insert($_POST);

				// Mise à jout des quantités	
				foreach ($_POST['quantite'] as $k => $quantite) {

					if ($quantite != 0) {
						$commentaire = $_POST['commentaire'][$k];

						$this->boncde_poste->insert(array(
							'sk_client' => $_POST['sk_client'],
							'numcde' => $_POST['numcde'],
							'sk_produit' => $k,
							'lb_produit' => $this->boncde_poste->recuplib('produit_had', 'sk_produit', $k, 'lb_produit'),
							'qt_produit' => $quantite,
							'co_produit' => $commentaire));
					}
					if (($quantite == 0) && ($_POST['commentaire'][$k]!=''))
					{
						$this->message('Vous devez entrer une quantite','error');
						$this->zones_page($_POST);
						$this->affiche("form");
						return;
					}
				}
				
				$this->message("Le bon de commande a été ajouté avec succés", "normal");
				///B.OCHUDLO le 20/11/2015 envoi du mail apr�s engregsitrement
				$this->envmailbcde($_POST['numcde'],true);
			} else {

				// UPDATE
				// Mise à jour du mail / quantité
				$this->boncde_poste_mail->delete('numcde', $numcde);

				$ancboncdes = $this->boncde_poste->query("SELECT * FROM boncde_poste where sk_client=:sk_client AND numcde='" . $_POST['numcde'] . "'", array('sk_client' => auth::$auth ['sk_client']));
				if ($ancboncdes) {
					foreach ($ancboncdes as $k => $ancboncde) {

						$this->boncde_poste_mail->insert(array(
							'sk_client' => auth::$auth ['sk_client'],
							'numcde' => $ancboncde['numcde'],
							'sk_produit' => $ancboncde['sk_produit'],
							'qt_produit' => $ancboncde['qt_produit']));
					}
				}

				// Mise à jour du bon de commande 				
				$this->boncde_entete->update('numcde', $numcde, $_POST);

				// Mise à jour des quantités du bon de commande
				///$this->boncde_poste->delete('numcde', $numcde, $_POST);/* Modification B.OCHUDLO : pas de suppression*/

				foreach ($_POST['quantite'] as $k => $quantite) {
					if ($quantite != 0) {
						$commentaire = $_POST['commentaire'][$k];
						
						/* Modification B.OCHUDLO : On v�rifie si l'enregistrement existe*/
						$count = $this->boncde_poste->queryFirst("SELECT count(*) as Nb FROM boncde_poste where sk_client=:sk_client AND sk_produit='" .$k . "' AND numcde='" . $_POST['numcde'] . "'", array('sk_client' => auth::$auth ['sk_client']));
						echo  $count ['Nb'];
						if ($count ['Nb']==1) {
							///on met � jour 
							
							$this->boncde_poste->update(array('sk_client','numcde','sk_produit'),array(auth::$auth ['sk_client'], $_POST['numcde'],$k),
									array(
									'qt_produit' => $quantite,
									'co_produit' => $commentaire));
						}
						else
						{
							///on insere 
							$this->boncde_poste->insert(array(
									'sk_client' => auth::$auth ['sk_client'],
									'numcde' => $_POST['numcde'],
									'sk_produit' => $k,
									'lb_produit' => $this->boncde_poste->recuplib('produit_had', 'sk_produit', $k, 'lb_produit'),
									'qt_produit' => $quantite,
									'co_produit' => $commentaire));
						}
					}

                                        if (($quantite == 0) && ($_POST['commentaire'][$k]!=''))
                                        {
                                                $this->message('Vous devez entrer une quantite','error');
                                                $this->zones_page($_POST);
                                                $this->affiche("form");
                                                return;
                                        }
				}
				$this->envmailbcde($_POST['numcde'],true);
				$this->message("Le bon de commande a été modifié avec succés", "normal");
			}
		}

		
		if (isset($_POST['btn_retour'])) {
			$this->zones_page($_POST);
			foreach ($_POST['quantite'] as $k => $quantite) {
				if ($quantite != 0) {
					$commentaire = $_POST['commentaire'][$k];
			
				}			
			}
				
			$this->affiche("form");
			
			return;
		}
		/*B.OCHUDLO redirection page aper�u commande*/
		
		if (!isset($_POST['btn_suivant'])) {
			unset($_POST);
			$this->redirect('accueil');
			return;
		}
		if (empty($hide_numcde)) {
			$this->zones_page($_POST);
			foreach ($_POST['quantite'] as $k => $quantite) {
				if ($quantite != 0) {
					$commentaire = $_POST['commentaire'][$k];
		
				}
		
			}
			
			$this->affiche("form");
			return;
			
		}else{
			$this->redirect($_SESSION['page_prec']);
		}
	}

	function rech_patient_had() {
		$search = sql_escape("{$_GET['term']}%");
		$search1 = sql_escape("{$_GET['term']}%");
		$data = $this->patient_had->query(
				"SELECT concat(lb_nom,CASE WHEN sk_patient IS NULL THEN concat(lb_nom2,' ') else '' end ,' ( ',lb_adresse, ' - ', lb_codepostal, ' ', lb_ville , ' ) ' ,' ( ',ext_patient,' )' ) as label , "
				. "lb_nom as value, ext_patient, lb_nom, lb_adresse, lb_ville, lb_codepostal, lb_telephone, CASE WHEN tmp_boncde_entete.nbCommande IS NULL THEN 0 ELSE tmp_boncde_entete.nbCommande END AS nbCommande, tmp_boncde_entete.numcde from patient_had LEFT JOIN (SELECT count( numpat ) AS nbCommande, numpat, max( numcde ) as numcde FROM boncde_entete GROUP BY numpat)tmp_boncde_entete ON patient_had.ext_patient = tmp_boncde_entete.numpat "
				. "where (ext_patient like :rech1 or TRIM(lb_nom) like :rech2 ) and patient_had.sk_client ='" . auth::$auth['sk_client'] . "' order by lb_nom LIMIT 100", array('rech1' => $search, 'rech2' => $search));
		echo json_encode($data);
		
	}
	
	
	
	public function envmailbcde($numcde = '*', $retour = true) {
		$this->mailbcde($numcde, $retour);
		$this->redirect($_SESSION['page_prec']);
	}

	public function mailbcde($numcde = '*', $retour = true) {

		if (isset($numcde) || $numcde != '*') {

			// Lecture enregistrement
			$boncde = $this->boncde_entete->find('numcde', $numcde);
			if ($boncde) {

				$boncde['datdem'] = datevershtml($boncde['datdem']);
				$boncde['datliv'] = datevershtml($boncde['datliv']);
				$boncde['datfinhad'] = datevershtml($boncde['datfinhad']);
				$boncde['jrsliv'] = datevershtml($boncde['jrsliv']);
				
				
				$this->smarty->assign('boncde', $boncde);

				$client = $this->client_had->findOrEmpty('sk_client', $boncde['sk_client']);
				$this->smarty->assign('client', $client);

				$utilisateur = $this->utilisateur->findOrEmpty('coduti', auth::$auth['coduti']);
				$this->smarty->assign('utilisateur', $utilisateur);

				$patient = $this->patient_had->findOrEmpty('ext_patient', $boncde['numpat']);
				$this->smarty->assign('patient', $patient);

				$raison = $this->raison_had->findOrEmpty('codrai', $boncde['raifinhad']);
				$this->smarty->assign('raison', $raison);	
				
				// liste des produits commandés
				$boncdemail = $this->boncde_poste_mail->find('numcde', $numcde);
				if (!$boncdemail) {
					$groupes = $this->boncde_poste->query(" select distinct(lb_hierachie) "
							. " from boncde_poste B left join produit_had P ON P.sk_produit = B.sk_produit "
							. " where B.sk_client=:sk_client and numcde=:numcde order by lb_classement ", array('sk_client' => auth::$auth ['sk_client'], 'numcde' => $numcde));
					$quantite = array();
					$commentaire = array();

					if ($groupes) {
					print_r($groupes);
						foreach ($groupes as $k => $groupe) {

							$groupe['produits'] = $this->boncde_poste->query("SELECT P.lb_produit, P.sk_produit, B.qt_produit, B.co_produit FROM boncde_poste B LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit and numcde='" . $numcde . "' WHERE lb_hierachie='" . $groupe['lb_hierachie'] . "' AND P.sk_client=:sk_client order by P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));

							foreach ($groupe['produits'] as $produit) {
								$quantite[$produit['sk_produit']] = $produit['qt_produit'];
								$commentaire[$produit['sk_produit']] = $produit['co_produit'];
							}
							$groupes[$k] = $groupe;
						}
					}
					$this->smarty->assign('groupes', $groupes);
					$this->smarty->assign('quantite', $quantite);
					$this->smarty->assign('commentaire', $commentaire);

					$this->smarty->assign('produit', $produit);
				} else {

					$produitsajout = $this->boncde_poste->query(" SELECT P.lb_produit, P.sk_produit, B.qt_produit  as qt_ecart, B.co_produit "
							. " FROM boncde_poste B "
							. "  LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit "
							. " WHERE P.sk_client=:sk_client and B.numcde='" . $numcde . "' and  B.sk_produit not in (SELECT sk_produit FROM boncde_poste_mail WHERE numcde='" . $numcde . "' AND Statut='A') "
							. " ORDER BY P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));

					$produitssupp = $this->boncde_poste->query(" SELECT P.lb_produit, P.sk_produit, B.qt_produit * -1 as qt_ecart "
							. " FROM boncde_poste_mail B"
							. " LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit "
							. " WHERE P.sk_client=:sk_client  and B.numcde='" . $numcde . "' and  B.sk_produit not in ( SELECT SK_produit FROM boncde_poste WHERE numcde='" . $numcde . "' AND statut='A' ) "
							. " ORDER BY P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));

					$produitsmaj = $this->boncde_poste->query(" SELECT P.lb_produit, P.sk_produit, B.qt_produit - M.qt_produit as qt_ecart, B.co_produit "
							. " FROM boncde_poste B "
							. " LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit "
							. " LEFT JOIN boncde_poste_mail M ON B.sk_produit = M.sk_produit and B.numcde=M.numcde "
							. " WHERE P.sk_client=:sk_client and B.numcde='" . $numcde . "' AND B.qt_produit<>M.qt_produit "
							. " ORDER BY lb_classement,P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));

					$this->smarty->assign('produitsajout', $produitsajout);
					$this->smarty->assign('produitssupp', $produitssupp);
					$this->smarty->assign('produitsmaj', $produitsmaj);

					if (empty($produitsajout) && empty($produitssupp) && empty($produitsmaj)) {

						// on renvoi le mail complet

						$groupes = $this->boncde_poste->query(" select distinct(lb_hierachie) "
								. " from boncde_poste B left join produit_had P ON P.sk_produit = B.sk_produit "
								. " where B.sk_client=:sk_client and numcde=:numcde order by lb_classement ", array('sk_client' => auth::$auth ['sk_client'], 'numcde' => $numcde));
						$quantite = array();
						$commentaire = array();

						if ($groupes) {

							foreach ($groupes as $k => $groupe) {

								$groupe['produits'] = $this->boncde_poste->query("SELECT P.lb_produit, P.sk_produit, B.qt_produit, B.co_produit FROM boncde_poste B LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit and numcde='" . $numcde . "' WHERE lb_hierachie='" . $groupe['lb_hierachie'] . "' AND P.sk_client=:sk_client order by P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));

								foreach ($groupe['produits'] as $produit) {
									$quantite[$produit['sk_produit']] = $produit['qt_produit'];
									$commentaire[$produit['sk_produit']] = $produit['co_produit'];
								}
								$groupes[$k] = $groupe;
							}
						}
						$this->smarty->assign('groupes', $groupes);
						$this->smarty->assign('quantite', $quantite);
						$this->smarty->assign('commentaire', $commentaire);

						$this->smarty->assign('produit', $produit);
					}
				}

				$message = $this->smarty->fetch(BASE_DIR . "pages/mailboncde.html");

				$pdf = $this->imprimer($numcde, true);

				$mail = new mail();
				$mail->setFrom("ExtranetHAD@bastide-medical.fr");
				$mail->addAddress($client['lb_mail_gest1']);
				$mail->addAddress($client['lb_mail_gest2']);
				$mail->Subject = "[EXTRANET HAD] - Enregistrement du bon de commande n° " . $numcde;
				$mail->msgHTML($message);
				$mail->addStringAttachment($pdf, 'Bons_cdes_' . $numcde . '.pdf', 'Base64', 'application/pdf');
				$mail->sendEmail();

				// UPDATE
				$this->boncde_entete->update('numcde', $numcde, array('datenvmail' => date('Y-m-d'), 'hrsenvmail' => date('H:i:s')));
				if ($retour)
					return true;
			}
		}
		if ($retour)
			return false;
		$this->redirect("/boncdes");
	}

	public function mailbcdeeve($numcde = '*', $raison, $retour = true) {

		if (isset($numcde) || $numcde != '*') {

			// Lecture enregistrement
			$boncde = $this->boncde_entete->find('numcde', $numcde);
			if ($boncde) {

				$boncde['raison'] = $raison;
				$boncde['moddat'] = datevershtml($boncde['moddat']);
				$this->smarty->assign('boncde', $boncde);

				$client = $this->client_had->findOrEmpty('sk_client', $boncde['sk_client']);
				$this->smarty->assign('client', $client);

				$utilisateur = $this->utilisateur->findOrEmpty('coduti', auth::$auth['coduti']);
				$this->smarty->assign('utilisateur', $utilisateur);

				$patient = $this->patient_had->findOrEmpty('ext_patient', $boncde['numpat']);
				$this->smarty->assign('patient', $patient);

				$message = $this->smarty->fetch(BASE_DIR . "pages/mailboncdeeve.html");

				$mail = new mail();
				$mail->setFrom("ExtranetHAD@bastide-medical.fr");
				$mail->addAddress($client['lb_mail_eve']);
				$mail->Subject = "[EXTRANET HAD] - Changement statut du bon de commande n° " . $numcde;
				$mail->msgHTML($message);
				$mail->sendEmail();

				// UPDATE
				if ($retour)
					return true;
			}
		}
		if ($retour)
			return false;
		$this->redirect("/boncdes");
	}

	public function imprimer($numcde = '*', $return = false) {
		/**
		 * ********************************************
		 * Affichage enregistrement à modifier
		 * *********************************************
		 */
		if (isset($numcde) || $numcde != '*') {

			// Lecture enregistrement
			$element = $this->boncde_entete->readkey('numcde', $numcde);

			// Si pas trouve alors on revient sur la liste
			if ($element) {

				$client = $this->client_had->findOrEmpty('sk_client', $element['sk_client']);

				$utilisateur = $this->utilisateur->findOrEmpty('coduti', auth::$auth['coduti']);

				$patient = $this->patient_had->findOrEmpty('ext_patient', $element['numpat']);

				// liste des produits commandés
				$groupes = $this->boncde_poste->query(" select distinct(lb_hierachie) "
						. " from boncde_poste B left join produit_had P ON P.sk_produit = B.sk_produit "
						. " where B.sk_client=:sk_client and numcde=:numcde order by lb_classement ", array('sk_client' => auth::$auth ['sk_client'], 'numcde' => $numcde));
				$quantite = array();
				$commentaire = array();

				if ($groupes) {

					foreach ($groupes as $k => $groupe) {
						$groupe['produits'] = $this->boncde_poste->query("SELECT P.lb_produit, P.sk_produit, B.qt_produit, B.co_produit FROM boncde_poste B LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit and numcde='" . $numcde . "' WHERE lb_hierachie='" . $groupe['lb_hierachie'] . "' AND P.sk_client=:sk_client order by P.lb_classement,P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));

						foreach ($groupe['produits'] as $produit) {
							$quantite[$produit['sk_produit']] = $produit['qt_produit'];
							$commentaire[$produit['sk_produit']] = $produit['co_produit'];
						}

						$groupes[$k] = $groupe;
					}
				}
				$this->smarty->assign('groupes', $groupes);
				$this->smarty->assign('quantite', $quantite);
				$this->smarty->assign('commentaire', $commentaire);
				//	$this->smarty->assign('produits', $produits);
				//	$element['produits'] = $produits;
				$element['datdem'] = datevershtml($element['datdem']);
				$element['datliv'] = datevershtml($element['datliv']);

				$this->smarty->assign('element', $element);

				$this->smarty->assign('client', $client);
				$this->smarty->assign('utilisateur', $utilisateur);
				$this->smarty->assign('patient', $patient);

				if ($return)
					return $this->smarty->pdf('boncdes/pdf.tpl', 'BON DE COMMANDE', 'Bons_cdes_' . $numcde . '.pdf', 'S');
				else
					$this->smarty->pdf('boncdes/pdf.tpl', 'BON DE COMMANDE', 'Bons_cdes_' . $numcde . '.pdf', 'I');
			} else {
				$this->liste();
			}
		} else {
			$this->liste();
		}
	}

}
?>