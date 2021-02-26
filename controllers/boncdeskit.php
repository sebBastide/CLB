<?php

class boncdeskitCtrl extends Controller {

	public $smarty;
	public $boncdekit_entete;
	public $boncdekit_poste;
	

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->boncdekit_entete = new dbtable('boncdekit_entete');
		$this->boncdekit_poste = new dbtable('boncdekit_poste');
		$this->boncde_poste_mail = new dbtable('boncde_poste_mail');
		$this->client_had = new dbtable('client_had');
		$this->patient_had = new dbtable('patient_had');
		$this->produit_kit = new dbtable('produit_kit');
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
			$client_had['lb_donneur_ordre'] = '<<<<<< Mode administrateur >>>>>>';
		} else {
			$client_had = $this->client_had->find('sk_client', auth::$auth['sk_client']);
		}
		$this->smarty->assign('client_had', $client_had);

		if ($page_a_afficher == "form") {
			$this->smarty->displayLayout('boncdeskit/fiche.tpl', 'Bon de commande kit');
		} elseif ($page_a_afficher == "list") {
			$this->smarty->displayLayout('boncdeskit/liste.tpl', 'Liste des bons de commandes kit');
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

		$r_boncdekit_entete = $_SESSION ['r_boncdekit_entete'];

		// CONSTRUCTION DU WHERE
		$wheres = array();
		
		if (isset($r_boncdekit_entete['r_statut']) && $r_boncdekit_entete ['r_statut'] != 'T' )
			$wheres [] = "B.statut='" . $r_boncdekit_entete ['r_statut'] . "'";
		
		if (isset($r_boncdekit_entete ['r_numcdekit']) && !empty($r_boncdekit_entete ['r_numcdekit']))
			$wheres [] = "numcdekit='" . sql_escape($r_boncdekit_entete ['r_numcdekit']) . "'";
		
		if (isset($r_boncdekit_entete ['r_numpat']) && !empty($r_boncdekit_entete ['r_numpat']))
			$wheres [] = "numpat='" . sql_escape($r_boncde_entete ['r_numpat']) . "'";

		if (isset($r_boncdekit_entete ['r_datdem']) && !empty($r_boncdekit_entete ['r_datdem']))
			$wheres [] = " datdem = '" . sql_escape(dateverssql($r_boncdekit_entete ['r_datdem'])) . "'";

		if (isset($r_boncdekit_entete ['r_datliv']) && !empty($r_boncdekit_entete ['r_datliv']))
			$wheres [] = " datliv = '" . sql_escape(dateverssql($r_boncdekit_entete ['r_datliv'])) . "'";

		if (isset($r_boncdekit_entete ['r_lb_nom']) && !empty($r_boncdekit_entete ['r_lb_nom']))
			$wheres [] = " lb_nom like '%" . sql_escape($r_boncdekit_entete ['r_lb_nom']) . "%'";

		// Restriction aux boncde_entete
		if (auth::$auth ['grputi'] != "A") {
			$wheres [] = "B.sk_client  = '" . auth::$auth ['sk_client'] . "'";
		}

		// RECUP. DU NOMBRE TOTAL D'ENREG.
		$sqlcount = "SELECT COUNT(*) AS CPT FROM boncdekit_entete B ";
		$count = $this->boncdekit_entete->queryFirst($sqlcount);

		// RECUP. DU NOMBRE D'ENREG. FILTRES.
		if (!empty($wheres))
			$countfilter = $this->boncdekit_entete->queryFirst($sqlcount . " WHERE " . implode(" AND ", $wheres));
		else
			$countfilter = $count;

		// CONSTRUCTION DE LA REQUETE.
		$fields = $this->datatable_columns($_GET);
		$sql = "SELECT " . implode(" , ", $fields) . " FROM boncdekit_entete B left join patient_had P ON numpat=P.ext_patient ";
		if (!empty($wheres))
			$sql .= " WHERE " . implode(" AND ", $wheres);
		$sql .= $this->datatable_order_offset($_GET, $fields);
	
		// EXECUTION DE LA REQUETE.
		$elements = $this->boncdekit_entete->query($sql, PDO::FETCH_NUM);

		// MISE EN FORME DES DONNEES ET AJOUT DES OPTIONS.
		$indcode = array_search('numcdekit', $fields);
		$inddatdem = array_search('datdem', $fields);
		$inddatliv = array_search('datliv', $fields);
		$inddatenvmail = array_search('datenvmail', $fields);
		$indstatut = array_search('B.statut', $fields);

		foreach ($elements as $k => $element) {

			$element[$inddatdem] = datevershtml($element[$inddatdem]);
			$element[$inddatliv] = datevershtml($element[$inddatliv]);
			$element[$inddatenvmail] = datevershtml($element[$inddatenvmail]);
			
			$element [] = '<a href="#" onclick="editer(\'' . $element [$indcode] . '\');"><img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier"></a>';
			if ($element[$indstatut] == 'A') $element[$indstatut] = 'En cours';
			if ($element[$indstatut] == 'D') $element[$indstatut] = 'Hospitalisation';
		
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
	public function liste($rp_numcdekit = '', $rp_datdem = '', $rp_datliv = '') {

		// valeur par defaut des recherches
		$r_boncdekit_entete = array(
			'r_numcdekit' => '',
			'r_numpat' => '',
			'r_lb_nom' => '',
			'r_datdem' => '',
			'r_datliv' => '',
			'r_statut' => 'A'
		);

		// integration des paramétres
		if ($rp_numcdekit != '*')
			$_SESSION ['r_boncdekit_entete']['r_numcdekit'] = $rp_numcdekit;

		if ($rp_datdem != '*') {
			$rp_datdem = str_replace('-', '/', $rp_datdem);
			$_SESSION ['r_boncdekit_entete']['r_datdem'] = $rp_datdem;
		}
		if ($rp_datliv != '*') {
			$rp_datliv = str_replace('-', '/', $rp_datliv);
			$_SESSION ['r_boncdekit_entete']['r_datliv'] = $rp_datliv;
		}

		if (isset($_SESSION ['r_boncdekit_entete']))
			$r_boncdekit_entete = array_copie($r_boncdekit_entete, $_SESSION ['r_boncdekit_entete']);
		if (isset($_POST))
			$r_boncdekit_entete = array_copie($r_boncdekit_entete, $_POST);
		// sauvegarde en session de la recherche
		$_SESSION ['r_boncdekit_entete'] = $r_boncdekit_entete;

		// initialisation des variables ecrans....
		$this->smarty->assign('r_boncdekit_entete', $r_boncdekit_entete);
		$this->affiche('list');
	}

	/**
	 * ********************************************
	 * Activer
	 * *********************************************
	 */
	public function activer($numcdekit) {
		if (isset($numcdekit)) {
			$this->boncdekit_entete->update('numcdekit', $numcdekit, array(
				'statut' => 'A'
			));
		}
	}

	/**
	 * ********************************************
	 * Desactiver
	 * *********************************************
	 */
	public function desactiver($numcdekit) {
		if (isset($numcdekit)) {
			$this->boncdekit_entete->update('numcdekit', $numcdekit, array(
				'statut' => 'D'
			));
		}
	}

	/**
	 * ********************************************
	 * Affichage enregistrement à modifier
	 * *********************************************
	 */
	public function modifier($numcdekit) {

		if (isset($numcdekit)) {
			
			$element['hide_numcdekit'] = $numcdekit;
			
			// Lecture enregistrement
			$element = $this->boncdekit_entete->find('numcdekit', $numcdekit);

			// si pas trouve alors on revient sur la liste
			if ($element) {

				$element['datdem'] = datevershtml($element['datdem']);
				$element['datliv'] = datevershtml($element['datliv']);
			
				// Lecture des kits
				$qtekit=array();
				$kits = $this->boncdekit_poste->query(" SELECT distinct(P.hierarchie), B.quantite "
													. "	FROM produit_kit P LEFT JOIN boncdekit_poste B ON numcdekit='" . $numcdekit . "' AND P.hierarchie=B.hierarchie AND typlig='K' "
						                            . " where P.sk_client=:sk_client order by P.hierarchie ", array('sk_client' => auth::$auth ['sk_client']));
				if ($kits) {			
					foreach ($kits as $k => $kit) {
						$qtekit[$kit['hierarchie']] = $kit['quantite'];
					}
				}
				// Lecture enregistrement
				$qtepdt=array();
				$produits = $this->boncdekit_poste->query(" SELECT * FROM produit_kit P "
														. " LEFT JOIN boncdekit_poste B ON numcdekit='" . $numcdekit . "' AND P.Reference=B.sk_produit AND typlig='P' "
														. " WHERE P.sk_client=:sk_client "
														. " order by libelle ", array('sk_client' => auth::$auth ['sk_client']));
				if ($produits) {
					foreach ($produits as $k => $produit) {
						$qtepdt[$produit['Reference']] = $produit['quantite'];
					}
				}

				$_SESSION['element'] = $element;

				$_SESSION['kits'] = $kits;
				$element['qtekit'] = $qtekit;	

				$_SESSION['produits'] = $produits;
				$element['qtepdt'] = $qtepdt;	

				$this->smarty->assign('produits', $produits);
				$this->smarty->assign('qtepdt', $qtepdt);
				$this->smarty->assign('qtekit', $qtekit);

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
		$element['hide_numcdekit'] = $element['numcdekit'];

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
		
		$this->smarty->assign('kits', $_SESSION['kits']);
		$this->smarty->assign('produits', $_SESSION['produits']);
		
		$this->smarty->assign('qtekit', $element['qtekit']);
		$this->smarty->assign('qtepdt', $element['qtepdt']);
	}

	/**
	 * *********************************************
	 * Affichage enregistrement vide pour ajout
	 * *********************************************
	 */
	public function ajouter() {

		$element = $this->boncdekit_entete->emptyRecord();
		
		$element['datdem'] = date('d/m/Y');
		$element['hide_numcdekit'] = ''; 
				
		// Lecture des kits
		$qtekit=array();
		$kits = $this->boncdekit_poste->query("select distinct(hierarchie) from produit_kit where sk_client=:sk_client order by hierarchie ", array('sk_client' => auth::$auth ['sk_client']));
		if ($kits) {			
			foreach ($kits as $k => $kit) {
				$qtekit[$kit['hierarchie']] = '0';
			}
		}
		// Lecture enregistrement
		$qtepdt=array();
		$produits = $this->boncdekit_poste->query("SELECT * FROM produit_kit WHERE sk_client=:sk_client order by libelle ", array('sk_client' => auth::$auth ['sk_client']));
		if ($produits) {
			foreach ($produits as $k => $produit) {
				$qtepdt[$produit['Reference']] = '0';
			}
		}

		$_SESSION['element'] = $element;
		
		$_SESSION['kits'] = $kits;
		$element['qtekit'] = $qtekit;	
		
		$_SESSION['produits'] = $produits;
		$element['qtepdt'] = $qtepdt;	

		$this->smarty->assign('produits', $produits);
		$this->smarty->assign('qtepdt', $qtepdt);
		$this->smarty->assign('qtekit', $qtekit);
		
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

			$hide_numcdekit = $_POST ['hide_numcdekit'];
			$numcdekit = $_POST ['numcdekit'];

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

			if (empty($hide_numcdekit)) {
				// INSERT
				$prefnum = $this->client_had->queryFirst("SELECT prefixe_num as pref FROM client_had WHERE sk_client=:sk_client", array('sk_client' => auth::$auth ['sk_client']));
				$dernum = $this->boncdekit_entete->queryFirst("SELECT max(substr(numcdekit,6,10)) as nummax FROM boncdekit_entete WHERE sk_client=:sk_client", array('sk_client' => auth::$auth ['sk_client']));

				$_POST['numcdekit'] = $prefnum['pref'] . '_K' . sprintf("%1$09d", ($dernum['nummax'] + 1));
				$_POST['sk_client'] = auth::$auth ['sk_client'];

				$this->boncdekit_entete->insert($_POST);
				
				// Mise à jour des quantités KIT	 
				foreach (array_keys($_POST['qtekit']) as $key) {
					if ($_POST['qtekit'][$key] != 0) {
						$kits = $this->boncdekit_poste->query("select * from produit_kit where sk_client=:sk_client AND hierarchie='".$key."'", array('sk_client' => auth::$auth ['sk_client']));
						if ($kits) {			
							foreach ($kits as $k => $kit) {

								$this->boncdekit_poste->insert(array(
									'sk_client' => auth::$auth ['sk_client'],
									'numcdekit' => $_POST['numcdekit'],
									'typlig' => 'K',
									'hierarchie' => $kit['hierarchie'],
									'sk_produit' => $kit['Reference'],
									'lb_produit' => $kit['libelle'],
									'co_produit' => $kit['composition'],
									'quantite' => $_POST['qtekit'][$key]));
							}
						}
					}
				}
				
				// Mise à jour des quantités PRODUITS	 
				foreach (array_keys($_POST['qtepdt']) as $key) {
									
					if ($_POST['qtepdt'][$key] != 0) {
						
						$produit = $this->boncdekit_poste->queryFirst("select * from produit_kit where sk_client=:sk_client AND Reference='".$key."'", array('sk_client' => auth::$auth ['sk_client']));
						if ($produit) {			
						
							$this->boncdekit_poste->insert(array(
								'sk_client' =>  auth::$auth ['sk_client'],
								'numcdekit' => $_POST['numcdekit'],
								'typlig' => 'P',
								'hierarchie' => $produit['hierarchie'],
								'sk_produit' => $produit['Reference'],
								'lb_produit' => $produit['libelle'],
								'co_produit' => $produit['composition'],
								'quantite' => $_POST['qtepdt'][$key]));
						}
					}
				}
				
				$this->message("Le bon de commande kit a été ajouté avec succés", "normal");
				
			} else {

				// UPDATE
				// Mise à jour du bon de commande 				
				$this->boncdekit_entete->update('numcdekit', $numcdekit, $_POST);

				// Mise à jour des quantités du bon de commande
				$this->boncdekit_poste->delete('numcdekit', $numcdekit, $_POST);

				// Mise à jour des quantités KIT	 
				foreach (array_keys($_POST['qtekit']) as $key) {
					if ($_POST['qtekit'][$key] != 0) {
						$kits = $this->boncdekit_poste->query("select * from produit_kit where sk_client=:sk_client AND hierarchie='".$key."'", array('sk_client' => auth::$auth ['sk_client']));
						if ($kits) {			
							foreach ($kits as $k => $kit) {

								$this->boncdekit_poste->insert(array(
									'sk_client' =>  auth::$auth ['sk_client'],
									'numcdekit' => $_POST['numcdekit'],
									'typlig' => 'K',
									'hierarchie' => $kit['hierarchie'],
									'sk_produit' => $kit['Reference'],
									'lb_produit' => $kit['libelle'],
									'co_produit' => $kit['composition'],
									'quantite' => $_POST['qtekit'][$key]));
							}
						}
					}
				}
				
				// Mise à jour des quantités PRODUITS	 
				foreach (array_keys($_POST['qtepdt']) as $key) {
									
					if ($_POST['qtepdt'][$key] != 0) {
						
						$produit = $this->boncdekit_poste->queryFirst("select * from produit_kit where sk_client=:sk_client AND Reference='".$key."'", array('sk_client' => auth::$auth ['sk_client']));
						if ($produit) {			
						
							$this->boncdekit_poste->insert(array(
								'sk_client' =>  auth::$auth ['sk_client'],
								'numcdekit' => $_POST['numcdekit'],
								'typlig' => 'P',
								'hierarchie' => $produit['hierarchie'],
								'sk_produit' => $produit['Reference'],
								'lb_produit' => $produit['libelle'],
								'co_produit' => $produit['composition'],
								'quantite' => $_POST['qtepdt'][$key]));
						}
					}
				}				
				
				$this->message("Le bon de commande kit a été modifié avec succés", "normal");
			}
		}

		unset($_POST);

		$this->redirect($_SESSION['page_prec']);
	}
	/**
	 * ********************************************
	 * Recherche patient
	 * *********************************************
	 */
	function rech_patient_had() {

		$search = sql_escape("%{$_GET['term']}%");
		$search1 = sql_escape("{$_GET['term']}%");
		$data = $this->patient_had->query(
				"SELECT concat(lb_nom,' ( ',lb_adresse, ' - ', lb_codepostal, ' ', lb_ville , ' ) ' ,' ( ',ext_patient,' )' ) as label , "
				. "lb_nom as value, ext_patient, lb_nom, lb_adresse, lb_ville, lb_codepostal, lb_telephone from patient_had "
				. "where (ext_patient like :rech1 or lb_nom like :rech2 ) and sk_client ='" . auth::$auth['sk_client'] . "' order by lb_nom LIMIT 100", array('rech1' => $search, 'rech2' => $search));
		echo json_encode($data);
	}
/**
	 * ********************************************
	 * Envoi mail
	 * *********************************************
	 */
	public function mailbcdekit($numcdekit = '*', $retour = true) {

		if (isset($numcdekit) || $numcdekit != '*') {

			// Lecture enregistrement
			$boncdekit = $this->boncdekit_entete->find('numcdekit', $numcdekit);
			if ($boncdekit) {

				$boncdekit['datdem'] = datevershtml($boncdekit['datdem']);
				$boncdekit['datliv'] = datevershtml($boncdekit['datliv']);
				
				$this->smarty->assign('boncdekit', $boncdekit);

				$client = $this->client_had->findOrEmpty('sk_client', $boncdekit['sk_client']);
				$this->smarty->assign('client', $client);

				$utilisateur = $this->utilisateur->findOrEmpty('coduti', auth::$auth['coduti']);
				$this->smarty->assign('utilisateur', $utilisateur);

				$patient = $this->patient_had->findOrEmpty('ext_patient', $boncdekit['numpat']);
				$this->smarty->assign('patient', $patient);

				// liste des kits commandés
				$groupes = $this->boncdekit_poste->query(" SELECT distinct(hierarchie), quantite "	
													  . " FROM boncdekit_poste "
													  . " WHERE sk_client=:sk_client AND numcdekit='" . $numcdekit . "' AND typlig='K' "
													  . " ORDER BY hierarchie ", array('sk_client' => auth::$auth ['sk_client']));
				$quantite = array();				
				if ($groupes) {
					foreach ($groupes as $k => $groupe) {
				
						$groupe['produits'] = $this->boncdekit_poste->query(" SELECT lb_produit, sk_produit, quantite, co_produit FROM boncdekit_poste "
																		  . " WHERE sk_client=:sk_client AND hierarchie='" . $groupe['hierarchie'] . "' AND numcdekit='" . $numcdekit . "' "
																		  . " ORDER BY hierarchie, lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						
						foreach ($groupe['produits'] as $produit) {
							$quantite[$produit['sk_produit']] = $produit['co_produit'];
						}
						$groupes[$k] = $groupe;
					}
				}
				$this->smarty->assign('groupes', $groupes);
				$this->smarty->assign('quantite', $quantite);

				$pdtsup = $this->boncdekit_poste->query(" SELECT lb_produit, sk_produit, quantite, co_produit FROM boncdekit_poste "
										 			   . " WHERE sk_client=:sk_client AND numcdekit='" . $numcdekit . "' AND typlig='P' "
													   . " ORDER BY lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
								
				$this->smarty->assign('pdtsup', $pdtsup);
				
				$message = $this->smarty->fetch(BASE_DIR . "pages/mailboncdekit.html");

				$pdf = $this->imprimer($numcdekit, true);

				$mail = new mail();
				$mail->setFrom("ExtranetHAD@bastide-medical.fr");
				$mail->addAddress($client['lb_mail_gest1']);
				$mail->addAddress($client['lb_mail_gest2']);
				$mail->Subject = "[EXTRANET HAD] - Enregistrement du bon de commande kit n° " . $numcdekit;
				$mail->msgHTML($message);
				$mail->addStringAttachment($pdf, 'Bons_cdeskit_' . $numcdekit . '.pdf', 'Base64', 'application/pdf');
				$mail->sendEmail();

				// UPDATE
				$this->boncdekit_entete->update('numcdekit', $numcdekit, array('datenvmail' => date('Y-m-d'), 'hrsenvmail' => date('H:i:s')));
				if ($retour)
					return true;
			}
		}
		if ($retour)
			return false;
		$this->redirect("/boncdeskit");
	}
/**
	 * ********************************************
	 * Impression
	 * *********************************************
	 */
	public function imprimer($numcdekit = '*', $return = false) {
		/**
		 * ********************************************
		 * Affichage enregistrement à modifier
		 * *********************************************
		 */
		if (isset($numcdekit) || $numcdekit != '*') {

			// Lecture enregistrement
			$element = $this->boncdekit_entete->readkey('numcdekit', $numcdekit);

			// Si pas trouve alors on revient sur la liste
			if ($element) {

				$client = $this->client_had->findOrEmpty('sk_client', $element['sk_client']);

				$utilisateur = $this->utilisateur->findOrEmpty('coduti', auth::$auth['coduti']);

				$patient = $this->patient_had->findOrEmpty('ext_patient', $element['numpat']);

				// liste des kits commandés
				// liste des kits commandés
				$groupes = $this->boncdekit_poste->query(" SELECT distinct(hierarchie), quantite "	
													  . " FROM boncdekit_poste "
													  . " WHERE sk_client=:sk_client AND numcdekit='" . $numcdekit . "' AND typlig='K' "
													  . " ORDER BY hierarchie ", array('sk_client' => auth::$auth ['sk_client']));
				$quantite = array();				
				if ($groupes) {
					foreach ($groupes as $k => $groupe) {
				
						$groupe['produits'] = $this->boncdekit_poste->query(" SELECT lb_produit, sk_produit, quantite, co_produit FROM boncdekit_poste "
																		  . " WHERE sk_client=:sk_client AND hierarchie='" . $groupe['hierarchie'] . "' AND numcdekit='" . $numcdekit . "' "
																		  . " ORDER BY hierarchie, lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						
						foreach ($groupe['produits'] as $produit) {
							$quantite[$produit['sk_produit']] = $produit['co_produit'];
						}
						$groupes[$k] = $groupe;
					}
				}
				$this->smarty->assign('groupes', $groupes);
				$this->smarty->assign('quantite', $quantite);

				$pdtsup = $this->boncdekit_poste->query(" SELECT lb_produit, sk_produit, quantite, co_produit FROM boncdekit_poste "
										 			   . " WHERE sk_client=:sk_client AND numcdekit='" . $numcdekit . "' AND typlig='P' "
													   . " ORDER BY lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
								
				$this->smarty->assign('pdtsup', $pdtsup);
				
				
				$element['datdem'] = datevershtml($element['datdem']);
				$element['datliv'] = datevershtml($element['datliv']);

				$this->smarty->assign('element', $element);

				$this->smarty->assign('client', $client);
				$this->smarty->assign('utilisateur', $utilisateur);
				$this->smarty->assign('patient', $patient);

				if ($return)
					return $this->smarty->pdf('boncdeskit/pdf.tpl', 'BON DE COMMANDE', 'Bons_cdeskit_' . $numcdekit. '.pdf', 'S');
				else
					$this->smarty->pdf('boncdeskit/pdf.tpl', 'BON DE COMMANDE', 'Bons_cdeskit_' . $numcdekit . '.pdf', 'I');
			} else {
				$this->liste();
			}
		} else {
			$this->liste();
		}
	}

}
