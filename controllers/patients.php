<?php

class patientsCtrl extends Controller {

	public $smarty;
	public $patient_had;
	public $client_had;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->patient_had = new dbtable('patient_had');
		$this->client_had = new dbtable('client_had');
		$this->boncdes_entete = new dbtable('boncde_entete');
		$this->bonrecs_materiel = new dbtable('bonrec_materiel');
		$this->bonrecs_dechet = new dbtable('bonrec_dechet');
		$this->boncde_poste = new dbtable('boncde_poste');
	}
	
	function defaut() {
		$this->liste();
	}
	
	/**
	 * Affiche la page avec smarty ( Fusion et affichage)
	 *
	 * @param string $page_a_afficher        	
	 */
	private function affiche($page_a_afficher) {
		
		if (empty(auth::$auth['sk_client'])) {
			$element['lb_donneur_ordre']='<<<<<< Mode administrateur >>>>>>';
		}else{
			$element = $this->client_had->find('sk_client', auth::$auth['sk_client']);
		}
		$this->smarty->assign('element', $element);
		if ($page_a_afficher == "form") {			
			$this->smarty->displayLayout('patients/fiche.tpl', 'Fiche patient');
		} elseif ($page_a_afficher == "list") {	
			$this->smarty->displayLayout('patients/liste.tpl', 'Liste des patients');
		} elseif ($page_a_afficher == "gerer") {
			$this->smarty->displayLayout('patients/gerer.tpl', 'Gérer patient');	
		} else {
			echo 'error';
		}
	}

	/**
	 * Fontion AJAX de recup du contenu de datatable
	 */
	public function tableau_json() {
		
		$r_patients = $_SESSION ['r_patients'];
		
		// CONSTRUCTION DU WHERE
		$wheres = array();
		
		if (isset($r_patients ['r_statut']) && $r_patients ['r_statut'] != 'T')
			$wheres [] = "statut='" . $r_patients ['r_statut'] . "'";
		
		if (isset($r_patients ['r_ext_patient']) && !empty($r_patients ['r_ext_patient']))
			$wheres [] = " ext_patient LIKE '%" . sql_escape($r_patients ['r_ext_patient']) . "%'";
		
		if (isset($r_patients ['r_lb_nom']) && !empty($r_patients ['r_lb_nom']))
			$wheres [] = " lb_nom LIKE '%" . sql_escape($r_patients ['r_lb_nom']) . "%'";

		if (isset($r_patients ['r_dt_naissance']) && !empty($r_patients ['r_dt_naissance']))
			$wheres [] = " dt_naissance = '" . sql_escape(dateverssql($r_patients ['r_dt_naissance'])) . "'";
		
		// Restriction aux utilisateurs
		if (auth::$auth ['grputi'] != "A") {
		    $wheres [] = "sk_client = '" . auth::$auth ['sk_client'] . "'";
	    }
	
		// RECUP. DU NOMBRE TOTAL D'ENREG.
		$sqlcount = "SELECT COUNT(*) AS CPT FROM patient_had ";
		$count = $this->patient_had->queryFirst($sqlcount . " WHERE ext_patient <> ''");
		
		// RECUP. DU NOMBRE D'ENREG. FILTRES.
		if (!empty($wheres))
			$countfilter = $this->patient_had->queryFirst($sqlcount . " WHERE " . implode(" AND ", $wheres) . " AND ext_patient <> ''");
		else
			$countfilter = $count;
		
		// CONSTRUCTION DE LA REQUETE.
		$fields = $this->datatable_columns($_GET);
		$sql = "SELECT " . implode(" , ", $fields) . " FROM patient_had WHERE ext_patient <> '' ";
		
		if (!empty($wheres))
			$sql .= 'AND ' . implode(" AND ", $wheres);
		$sql .= $this->datatable_order_offset($_GET, $fields);
	
		// EXECUTION DE LA REQUETE.
		$elements = $this->patient_had->query($sql, PDO::FETCH_NUM);
		
		// MISE EN FORME DES DONNEES ET AJOUT DES OPTIONS.
		$indcode = array_search('ext_patient', $fields);
		$inddatnais = array_search('dt_naissance', $fields);
		$indstatut = array_search('statut', $fields);
		
		foreach ($elements as $k => $element) {
			
			//$element[] = '<a href="/patients/modifier/' . $element [$indcode] . '"><img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier"></a>';

			$element[] = '<a href="/patients/gerer/' . $element[$indcode] . '"><img src="/img/pictos/edit.gif" alt="Gérer" title="Gérer"></a>';
			
			$element[$inddatnais] = datevershtml($element[$inddatnais], 'Y-m-d H:i:s');
	
			/*if ($element[$indstatut] == 'A')
				$element[] = '<a href="#" onclick="desactiver(\'' . $element[$indcode] . '\');"><img src="/img/pictos/del.png"   alt="Désactiver" title="Supprimer"/></a>';
			else
				$element[] = '<a href="#" onclick="activer(\'' . $element[$indcode] . '\');"><img src="/img/pictos/react.png" alt="Activer"    title="Réactiver"   /></a>';*/
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
	 * Affichage table des patients
	 * **********************************************
	 */
	public function liste($r_num='', $r_nom='', $r_datnais='') {
		
		// valeur par defaut des recherches
		$r_patients = array(
			'r_ext_patient' => '',
			'r_lb_nom' => '',
			'r_dt_naissance' => '',
			'r_statut' => ''			
		);
		
		if ($r_num!='*')
		$_SESSION ['r_patients']['r_ext_patient']=$r_num;
		
		if ($r_nom!='*')
		$_SESSION ['r_patients']['r_lb_nom']=$r_nom;
		
		if ($r_datnais!='*'){
			$r_datnais = str_replace('-', '/', $r_datnais);
			$_SESSION ['r_patients']['r_dt_naissance']=$r_datnais;
		}
		if (isset($_SESSION ['r_patients']))
			$r_patients = array_copie($r_patients, $_SESSION ['r_patients']);

		if (isset($_POST))
			$r_patients = array_copie($r_patients, $_POST);

		// sauvegarde en session de la recherche
		$_SESSION ['r_patients'] = $r_patients;

		// initialisation des variables ecrans....
		$this->smarty->assign('r_patients', $r_patients);
		$this->affiche('list');
	}

	/**
	 * ********************************************
	 * Affichage enregistrement à modifier
	 * *********************************************
	 */
	public function gerer($ext_patient) {
			
		if (isset($ext_patient)) {

			// Lecture enregistrement
			$patient= $this->patient_had->find('ext_patient', $ext_patient);
			
			// si pas trouve alors on revient sur la liste
			if ($patient) {
				
				$patient['hide_ext_patient'] = $patient['ext_patient'];	
				$patient['hide_sk_patient'] = $patient['sk_patient'];	
				
				if (empty(auth::$auth['sk_client'])) {
					$client['lb_donneur_ordre']='<<<<<< Mode administrateur >>>>>>';
				}else{
					$client = $this->client_had->find('sk_client', auth::$auth['sk_client']);
				}
				// Dernières commandes 
				$boncdes_entete = array(array('numcde' => '', 'datdem' => '', 'numpat' => '', 'datliv'=> '', 'brm'=>array(array('numbrmat' => '', 'datdem' => '', 'datrec'=>'')), 'brd'=>array(array('numbrdec' => '', 'datdem' => '', 'datrec'=>''))));	

				if (auth::$auth['grputi'] == 'U' ) {
					// Lecture enregistrement
					$boncdes_entete = $this->boncdes_entete->query("SELECT numcde, datdem, numpat, datliv, CASE WHEN ISNULL(s.label) = 1 THEN 'En attente' ELSE s.label END as status, DATE_FORMAT(dateStatus, '%d/%m/%Y %H:%i:%s') as dateStatus FROM boncde_entete LEFT JOIN orderStatus s ON s.id = boncde_entete.statusId WHERE sk_client='" . auth::$auth['sk_client'] . "' AND numpat ='".$patient['ext_patient']. "' ORDER BY numcde DESC LIMIT 1000");
					if ($boncdes_entete) {
						foreach ($boncdes_entete as $k => $boncde_entete) {
							$boncde_entete['brm'] = $this->bonrecs_materiel->query("SELECT numbrmat, datdem, datrec, CASE WHEN ISNULL(s.label) = 1 THEN 'En attente' ELSE s.label END as status, DATE_FORMAT(dateStatus, '%d/%m/%Y %H:%i:%s') as dateStatus FROM bonrec_materiel LEFT JOIN orderStatus s ON s.id = bonrec_materiel.statusId WHERE sk_client='" . auth::$auth['sk_client']. "' AND numbrmat like '".$boncde_entete['numcde']."_M%' ORDER BY numbrmat DESC LIMIT 1000");
							if ($boncde_entete['brm']) {
							}else{
								$boncde_entete['brm'] = array(array('numbrmat' => '', 'datdem' => '', 'datrec' => '', 'status' => '', 'dateStatus' => ''));
							}	
							
//							$boncde_entete['brd'] = $this->bonrecs_dechet->query("SELECT numbrdec, datdem, datrec  FROM bonrec_dechet WHERE sk_client='". auth::$auth['sk_client']. "' AND numbrdec like '".$boncde_entete['numcde']."_D%' ORDER BY numbrdec DESC LIMIT 1000");
//							if ($boncde_entete['brd']) {
//							}else{
//								$boncde_entete['brd'] = array(array('numbrdec' => '', 'datdem' => '', 'datrec'=>''));		
//							}	

							$boncdes_entete[$k]=$boncde_entete;	
						}
						
					} else {
						$boncdes_entete = array(array('numcde' => '', 'datdem' => '', 'numpat' => '', 'datliv'=> '', 'status' => '', 'dateStatus' => '', 'brm'=>array(array('numbrmat' => '', 'datdem' => '', 'datrec' => '', 'status' => '', 'dateStatus' => '')), 'brd'=>array(array('numbrdec' => '', 'datdem' => '', 'datrec'=>''))));
					}
				}
				/*Debut B.OCHUDLO  */
				//$boncde = $this->boncde_poste->emptyRecord();
				/*$sqlLisProduitPatient ="SELECT P.lb_produit, P.sk_produit, B.qt_produit, B.co_produit,DATE_FORMAT( B.credat, '%d/%m/%y' ) AS credat,E.numcde  ". 
						"FROM boncde_poste B LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit ".
						"INNER JOIN boncde_entete E ON E.numcde = B.numcde ". 
						"LEFT JOIN bonrec_materiel br on LEFT(br.numbrmat,14) = B.numcde ".
						"LEFT JOIN bonrec_poste brp on brp.numbrmat= br.numbrmat AND brp.sk_produit=B.sk_produit ".
						"WHERE E.numpat='" . $patient['ext_patient'] . "' AND  brp.numbrmat IS NULL  order by E.numcde DESC ";
				*/
				// S.SAURY le 30.05.2016 : le bon de recup se trouve dans la table boncde_poste, donc suppression du lien vers bonrec_poste
				$sqlLisProduitPatient ="SELECT P.lb_produit, P.sk_produit, B.qt_produit, B.co_produit,DATE_FORMAT( B.credat, '%d/%m/%y' ) AS credat,E.numcde  ". 
						"FROM boncde_poste B LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit ".
						"INNER JOIN boncde_entete E ON E.numcde = B.numcde ". 
						"WHERE E.numpat='" . $patient['ext_patient'] . "' AND (B.numbrmat not like 'CLB%'  )  order by E.numcde DESC ";
				
				$boncde = $this->boncde_poste->query($sqlLisProduitPatient);
				$quantite = array();
				$commentaire = array();
			
				if ($boncde) {
								
					foreach ($boncde as $k => $bonc) {
						$boncde[$k] = $bonc;
					}
				// gestion des produits à récupérer
				if (isset($_POST['arecup'])) { 
						foreach($_POST['arecup'] as $k=>$arecup){
							$_POST ['arecup'][$k] = (isset($arecup) && $arecup == 'on') ? 1 : 0;
						}
					}else{
						$_POST['arecup']=array(); 
					}
				foreach ($_POST['arecup'] as $k=>$arecup) {	
					
						$this->bonrec_poste->insert(array(
							'sk_client'=> auth::$auth ['sk_client'], 
							'numbrmat'=> $_POST['numbrmat'], 
							'sk_produit'=>$_POST['sk_produit'],
							'lb_produit'=>$this->bonrec_poste->recuplib('produit_had','sk_produit', $k, 'lb_produit'),
							'arecup'=>1));		
						
				}
				}
				
				//$this->smarty->assign('groupes', $groupes);
				$this->smarty->assign('boncde', $boncde);
				$this->smarty->assign('quantite', $quantite);
				$this->smarty->assign('commentaire', $commentaire);
				
				//$this->smarty->assign('produit', $produit);
				/*Fin B.OCHUDLO  */
				$this->smarty->assign('boncdes_entete', $boncdes_entete);
			
				$this->smarty->assign('patient', $patient);
				$this->smarty->assign('client', $client);
				$this->smarty->displayLayout('patients/gerer.tpl', 'Gérer patient');
			} else {
				$this->liste();
			}
		}
	}
		
	public function ajouter() {
		/**
		 * *********************************************
		 * Affichage enregistrement vide pour ajout
		 * *********************************************
		 */
		$patient = $this->patient_had->emptyRecord();
		$patient['hide_ext_patient'] = '';

		$this->smarty->assign('patient', $patient);
		$this->affiche("form");
	}

	public function modifier($ext_patient) {
		/**
		 * ********************************************
		 * Affichage enregistrement à modifier
		 * *********************************************
		 */
		if (isset($ext_patient)) {
			// Lecture enregistrement
			$patient = $this->patient_had->readkey('ext_patient', $ext_patient);
			// si pas trouve alors on revient sur la liste
			if ($patient) {
				$patient['hide_ext_patient'] = $patient['ext_patient'];
				$this->smarty->assign('patient', $patient);
				$this->affiche('form');
			} else {
				$this->liste();
			}
		}
	}
	
	public function enregistrer() {
		/**
		 * *********************************************
		 * Enregistrement modification
		 * *********************************************
		 */
		if (isset($_POST['btn_enregistrer'])) {
		
			$ext_patient = $_POST ['ext_patient'];

			//=======================
			// Controle de la saisie
			//=======================
			//=======================
			// infos générales
			//=======================
			// SK_client
			if (empty($_POST['ext_patient'])) {
				$this->erreur('N° de patient HAD invalide', 0, 'ext_patient');
			}
			if (empty($_POST['hide_ext_patient'])) {
				$patient = $this->patient_had->queryFirst("SELECT count(*) as w_cpt FROM patient_had WHERE ext_patient=" . $_POST ['ext_patient']);
		
				//si Doublon sk_client...
				if ($patient ['w_cpt'] != 0) {
					$this->erreur('Ce n° de patient HAD existe déjà : saisie invalide', 0, 'ext_patient');
				}
			}
			// Nom
			if (empty($_POST['lb_nom'])) {
				$this->erreur('Nom patient HAD invalide', 1, 'lb_nom');
			}
			if (empty($_POST['lb_adresse'])) {
				$this->erreur('Adresse patient HAD invalide', 1, 'lb_adresse');
			}
			if (empty($_POST['lb_codepostal'])) {
				$this->erreur('Code postal patient HAD invalide', 1, 'lb_codepostal');
			}
			if (empty($_POST['lb_ville'])) {
				$this->erreur('Ville patient HAD invalide', 1, 'lb_ville');
			}
			if (empty($_POST['lb_telephone'])) {
				$this->erreur('Téléphone patient HAD invalide', 1, 'lb_telephone');
			}
			
			// saisie valide -> mise à jour base
			if (empty($_POST['hide_ext_patient'])) {
			
				$_POST['Sk_client']	= auth::$auth['sk_client'];
				
				$this->patient_had->insert($_POST);
			
			} else {
				// UPDATE
				$this->patient_had->update('ext_patient', $ext_patient, $_POST);
			}
			unset($_POST);
		}
			$this->liste();
	}

	public function erreur($error, $tabactif = 0, $zoneerr = '') {
		/**
		 * *********************************************
		 * Message d'erreur
		 * *********************************************
		 */
	
		$this->message($error, 'error');
		$this->smarty->assign('tabactif', $tabactif);
		$this->smarty->assign('zoneerr', $zoneerr);
		$this->smarty->assign('patient', $_POST);
		$this->affiche("form");
		exit();
	}
	
	
	public function desactiver($ext_patient) {
		/**
		 * **********************************************
		 * Désactivation 
		 * **********************************************
		 */
		if (isset($ext_patient)) {
			$this->patient_had->update('ext_patient', $ext_patient, array(
				'statut' => 'D'
			));
			$this->liste();
		}
	}

	public function activer($ext_patient) {
		/**
		 * **********************************************
		 * Activation
		 * **********************************************
		 */
		if (isset($ext_patient)) {
			$this->patient_had->update('ext_patient', $ext_patient, array(
				'statut' => 'A'
			));
			$this->liste();
		}
	}
	
}
