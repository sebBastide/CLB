<?php

class boncdesCtrl extends Controller {

	public $smarty;
	public $boncde_entete;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->boncde_entete = new dbtable('boncde_entete');
		$this->boncde_poste = new dbtable('boncde_poste');
		$this->client_had = new dbtable('client_had');
		$this->patient_had = new dbtable('patient_had');
		$this->produit_had = new dbtable('produit_had');
		$this->utilisateur = new dbtable('UTILISATEURS');
	}

	public function defaut() {
		$this->liste();
	}

	/**
	 * **************************************************
	 * Affiche la page avec smarty ( Fusion et affichage)
	 * ************************************************** 
	 * @param string $page_a_afficher        	
	 */
	private function affiche($page_a_afficher) {
		
		if (empty(auth::$auth['sk_client'])) {
			$client_had['lb_donneur_ordre']='<<<<<< Mode administrateur >>>>>>';
		}else{
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
		
		if (isset($r_boncde_entete['r_statut']) && $r_boncde_entete ['r_statut'] != 'T')
			$wheres [] = "B.statut='" . $r_boncde_entete ['r_statut'] . "'";
		
		if (isset($r_boncde_entete ['r_numcde']) && !empty($r_boncde_entete ['r_numcde']))
			$wheres [] = "numcde='" . sql_escape($r_boncde_entete ['r_numcde']) . "'";
		
		if (isset($r_boncde_entete ['r_datdem']) && !empty($r_boncde_entete ['r_datdem']))
			$wheres [] = " datdem = '" . sql_escape(dateverssql ($r_boncde_entete ['r_datdem'])) . "'";
		
		if (isset($r_boncde_entete ['r_datliv']) && !empty($r_boncde_entete ['r_datliv']))
			$wheres [] = " datliv = '" . sql_escape(dateverssql ($r_boncde_entete ['r_datliv'])) . "'";
		
		if (isset($r_boncde_entete ['r_lb_nom']) && !empty($r_boncde_entete ['r_lb_nom']))
			$wheres [] = " lb_nom like '%" . sql_escape($r_boncde_entete ['r_lb_nom']) . "%'";
		
// Restriction aux boncde_entete
		if (auth::$auth ['grputi']!="A") {
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
		$sql = "SELECT " . implode(" , ", $fields) . " FROM boncde_entete B left join patient_had P ON numpat=P.ext_patient ";
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
		
		$indstatut = array_search('B.statut', $fields);
		
		foreach ($elements as $k => $element) {
			
			$element[$inddatdem]=  datevershtml($element[$inddatdem]);
			$element[$inddatliv] = datevershtml($element[$inddatliv]);
			$element[$inddatenvmail] = datevershtml($element[$inddatenvmail]);
			
			$element [] = '<a href="#" onclick="editer(\'' . $element [$indcode] . '\');"><img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier"></a>';

			if ($element[$indstatut] == 'A')
				$element[] = '<a href="#" onclick="desactiver(\'' . $element[$indcode] . '\');"><img src="/img/pictos/del.png"   alt="Désactiver" title="Désactiver"/></a>';
			else
				$element[] = '<a href="#" onclick="activer(\'' . $element[$indcode] . '\');"><img src="/img/pictos/react.png" alt="Activer"    title="Activer"   /></a>';

			
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
	public function liste($rp_numcde='', $rp_datdem='', $rp_datliv='') {

	// valeur par defaut des recherches
		$r_boncde_entete = array(
			'r_numcde' => '',
			'r_lb_nom' => '',
			'r_datdem' => '',
			'r_datliv' => '',
			'r_statut' => 'A'			
		);
		
		// integration des paramétres
		if ($rp_numcde!='*')
			$_SESSION ['r_boncde_entete']['r_numcde']=$rp_numcde;
		
		if ($rp_datdem!='*'){
			$rp_datdem = str_replace('-', '/', $rp_datdem);
			$_SESSION ['r_boncde_entete']['r_datdem']=$rp_datdem;
		}
		if ($rp_datliv!='*'){
			$rp_datliv = str_replace('-', '/', $rp_datliv);
			$_SESSION ['r_boncde_entete']['r_datliv']=$rp_datliv;
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
	 * Desactiver
	 * *********************************************
	 */
	public function desactiver($numcde) {
		if (isset($numcde)) {
			$this->boncde_entete->update('numcde', $numcde, array(
				'statut' => 'D'
			));
		}
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
				$groupes = $this->boncde_poste->query("select distinct(lb_groupe_marchandise) "
													. "from produit_had where sk_client=:sk_client order by lb_groupe_marchandise ", array('sk_client' => auth::$auth ['sk_client']));
				$quantite=array();
				$commentaire=array();
						
				if ($groupes) {

					foreach ($groupes as $k => $groupe) {
						$groupe['produits'] = $this->boncde_poste->query("SELECT P.lb_produit, P.sk_produit, B.qt_produit, B.co_produit FROM produit_had P LEFT JOIN boncde_poste B ON P.sk_produit = B.sk_produit and numcde='".$numcde."' WHERE lb_groupe_marchandise='" . $groupe['lb_groupe_marchandise']. "' AND P.sk_client=:sk_client order by P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						foreach ($groupe['produits'] as $produit) {
							$quantite[$produit['sk_produit']]= $produit['qt_produit'];
							$commentaire[$produit['sk_produit']]= $produit['co_produit'];		
						}
						$groupes[$k]=$groupe;
					}
				}
				$_SESSION['element']=$element;
				$_SESSION['groupes']=$groupes;

				$this->smarty->assign('groupes', $groupes);		
				$element['quantite']=$quantite;	
				$element['commentaire']=$commentaire;	
				
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
		
		$element=array_ajoute($element, $_SESSION['element']);
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
		$groupes = $this->boncde_poste->query("select distinct(lb_groupe_marchandise) "
					. "from produit_had where sk_client=:sk_client order by lb_groupe_marchandise ", array('sk_client' => auth::$auth ['sk_client']));
		
		if ($groupes) {

			foreach ($groupes as $k => $groupe) {
				$groupe['produits'] = $this->boncde_poste->query("SELECT lb_produit, sk_produit FROM produit_had WHERE lb_groupe_marchandise='" . $groupe['lb_groupe_marchandise']. "' AND sk_client=:sk_client order by lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
				foreach ($groupe['produits'] as $produit) {
					$quantite[$produit['sk_produit']]= 0;
					$commentaire[$produit['sk_produit']]= '';					
				}
				$groupes[$k]=$groupe;
			}
		}
		$_SESSION['element']=$element;
		$_SESSION['groupes']=$groupes;
		
		$this->smarty->assign('groupes', $groupes);		
		$element['quantite']=$quantite;	
		$element['commentaire']=$commentaire;	
		
		$this->zones_page($element);
		$this->affiche("form");
	}

	/**
	 * *********************************************
	 * Enregistrement modification
	 * *********************************************
	 */
	public function enregistrer() {
		
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
			$_POST['datliv']=  dateverssql($_POST['datliv']);
			$_POST['datdem']=  dateverssql($_POST['datdem']);
			
			if (empty($hide_numcde)) {
				// INSERT
				$prefnum = $this->client_had->queryFirst("SELECT prefixe_num as pref FROM client_had WHERE sk_client=:sk_client", array('sk_client' => auth::$auth ['sk_client']));
				$dernum = $this->boncde_entete->queryFirst("SELECT max(substr(numcde,5,10)) as nummax FROM boncde_entete WHERE sk_client=:sk_client", array('sk_client' => auth::$auth ['sk_client']));
				
				$_POST['numcde'] = $prefnum['pref']  . '_' . sprintf ( "%1$010d", ($dernum['nummax']+1));				
				$_POST['sk_client'] = auth::$auth ['sk_client'];
				
				$this->boncde_entete->insert($_POST);
				
				// Mise à jout des quantités	
				foreach ($_POST['quantite'] as $k=>$quantite) {	
					
					if ($quantite !=0){
						$commentaire=$_POST['commentaire'][$k];
						$this->boncde_poste->insert(array(
							'sk_client'=> $_POST['sk_client'], 
							'numcde'=> $_POST['numcde'], 
							'sk_produit'=>$k,
							'lb_produit'=>$this->boncde_poste->recuplib('produit_had','sk_produit', $k, 'lb_produit'),
							'qt_produit'=>$quantite,
							'co_produit'=>$commentaire));						
					}
				}
				
				$this->message("Le bon de commande a été ajouté avec succés", "normal");
			} else {
				logtxt($_POST);
				
				// UPDATE
				$this->boncde_entete->update('numcde', $numcde, $_POST);

				// Mise à jout des quantités
				$this->boncde_poste->delete('numcde', $numcde, $_POST);

				foreach ($_POST['quantite'] as $k=>$quantite) {	
					if ($quantite !=0){
						$commentaire=$_POST['commentaire'][$k];
						$this->boncde_poste->insert(array(
							'sk_client'=> auth::$auth ['sk_client'], 
							'numcde'=> $_POST['numcde'], 
							'sk_produit'=>$k,
							'lb_produit'=>$this->boncde_poste->recuplib('produit_had','sk_produit', $k, 'lb_produit'),
							'qt_produit'=>$quantite,
							'co_produit'=>$commentaire));		
						}
				}
				$this->message("Le bon de commande a été modifié avec succés", "normal");
			}
		}
		
		unset($_POST);
		
		$this->redirect($_SESSION['page_prec']);
	}

	function rech_patient_had() {
		
		$search = sql_escape("%{$_GET['term']}%");
		$search1 = sql_escape("{$_GET['term']}%");
		$data = $this->patient_had->query(
				"SELECT concat(lb_nom,' ( ',lb_adresse, ' - ', lb_codepostal, ' ', lb_ville , ' ) ' ) as label , "
				. "lb_nom as value, ext_patient, lb_nom, lb_adresse, lb_ville, lb_codepostal, lb_telephone from patient_had "
				. "where (ext_patient like :rech1 or lb_nom like :rech2 ) and sk_client ='".auth::$auth['sk_client']."' order by lb_nom LIMIT 100", array('rech1' => $search, 'rech2' => $search));
		echo json_encode($data);
	}
	
	public function mailbcde($numcde = '*', $retour = true) {

		if (isset($numcde) || $numcde != '*') {
			
			// Lecture enregistrement
			$boncde = $this->boncde_entete->find('numcde', $numcde);
			if ($boncde) {
				
				$boncde['datdem'] = datevershtml($boncde['datdem']);
				$boncde['datliv'] = datevershtml($boncde['datliv']);			
				$this->smarty->assign('boncde', $boncde);
				
				$client = $this->client_had->findOrEmpty('sk_client', $boncde['sk_client']);
				$this->smarty->assign('client', $client);
				
				$utilisateur = $this->utilisateur->findOrEmpty('coduti', auth::$auth['coduti']);
				$this->smarty->assign('utilisateur', $utilisateur);
				
				$patient = $this->patient_had->findOrEmpty('ext_patient', $boncde['numpat']);
				$this->smarty->assign('patient', $patient);
				
				// liste des produits commandés
				$groupes = $this->boncde_poste->query(" select distinct(lb_groupe_marchandise) "
													. " from boncde_poste B left join produit_had P ON P.sk_produit = B.sk_produit "
													. " where B.sk_client=:sk_client and numcde=:numcde order by lb_groupe_marchandise ", array('sk_client' => auth::$auth ['sk_client'], 'numcde' => $numcde));
				$quantite=array();
				$commentaire=array();
						
				if ($groupes) {

					foreach ($groupes as $k => $groupe) {
						$groupe['produits'] = $this->boncde_poste->query("SELECT P.lb_produit, P.sk_produit, B.qt_produit, B.co_produit FROM boncde_poste B LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit and numcde='".$numcde."' WHERE lb_groupe_marchandise='" . $groupe['lb_groupe_marchandise']. "' AND P.sk_client=:sk_client order by P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						foreach ($groupe['produits'] as $produit) {
							$quantite[$produit['sk_produit']]= $produit['qt_produit'];
							$commentaire[$produit['sk_produit']]= $produit['co_produit'];		
						}
						$groupes[$k]=$groupe;
					}
				}
				$this->smarty->assign('groupes', $groupes);	
				$this->smarty->assign('quantite', $quantite);	
				$this->smarty->assign('commentaire', $commentaire);	
				
				
				// PDF
				//$pdf = $this->imprimer($numcde, true);
				
				$this->smarty->assign('produit', $produit);
			
				
				$message = $this->smarty->fetch(BASE_DIR . "pages/mailboncde.html");
	
				$mail = new mail();
				$mail->setFrom("ExtranetHAD@bastide-medical.fr");
				$mail->addAddress($client['lb_mail_gest']);
				$mail->Subject = "[EXTRANET HAD] - Enregistrement du bon de commande n° " . $numcde ;
				$mail->msgHTML($message);
				//$mail->addStringAttachment($pdf, 'BonDeCde_' . $numcde . '.pdf', 'Base64', 'application/pdf');
				$mail->sendEmail();
				
				// UPDATE
				$this->boncde_entete->update('numcde', $numcde, array('datenvmail'=>date('Y-m-d'), 'hrsenvmail' => date('H:i:s')));
				if ($retour)	
					return true;
			}
		}
		if ($retour)
			return false;
		$this->redirect("/boncdes");
	}
}
