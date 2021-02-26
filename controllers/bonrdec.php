<?php

class bonrdecCtrl extends Controller {

	public $smarty;
	public $bonrec_dechet;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->boncde_entete = new dbtable('boncde_entete');
		$this->bonrec_dechet = new dbtable('bonrec_dechet');
		$this->client_had = new dbtable('client_had');
		$this->patient_had = new dbtable('patient_had');
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
			$this->smarty->displayLayout('bonrdec/fiche.tpl', 'Bon de récupération déchet');
		} elseif ($page_a_afficher == "list") {
			$this->smarty->displayLayout('bonrdec/liste.tpl', 'Liste des bons de récupérations déchets');
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
		
		$r_bonrec_dechet = $_SESSION ['r_bonrec_dechet'];
		
		// CONSTRUCTION DU WHERE
		$wheres = array();
		
		if (isset($r_bonrec_dechet['r_statut']) && $r_bonrec_dechet ['r_statut'] != 'T')
			$wheres [] = "B.statut='" . $r_bonrec_dechet ['r_statut'] . "'";
		
		if (isset($r_bonrec_dechet ['r_numbrdec']) && !empty($r_bonrec_dechet ['r_numbrdec']))
			$wheres [] = "numbrdec='" . sql_escape($r_bonrec_dechet ['r_numbrdec']) . "'";
		
		if (isset($r_bonrec_dechet ['r_datdem']) && !empty($r_bonrec_dechet ['r_datdem']))
			$wheres [] = " datdem = '" . sql_escape(dateverssql ($r_bonrec_dechet ['r_datdem'])) . "'";
		
		if (isset($r_bonrec_dechet ['r_datrec']) && !empty($r_bonrec_dechet ['r_datrec']))
			$wheres [] = " datrec = '" . sql_escape(dateverssql ($r_bonrec_dechet ['r_datrec'])) . "'";
		
		if (isset($r_bonrec_dechet ['r_lb_nom']) && !empty($r_bonrec_dechet ['r_lb_nom']))
			$wheres [] = " lb_nom like '%" . sql_escape($r_bonrec_dechet ['r_lb_nom']) . "%'";
		
// Restriction aux bonrec_dechet
		if (auth::$auth ['grputi']!="A") {
			$wheres [] = "B.sk_client  = '" . auth::$auth ['sk_client'] . "'";
		}
		
		// RECUP. DU NOMBRE TOTAL D'ENREG.
		$sqlcount = "SELECT COUNT(*) AS CPT FROM bonrec_dechet B";
		$count = $this->bonrec_dechet->queryFirst($sqlcount);
		
		// RECUP. DU NOMBRE D'ENREG. FILTRES.
		if (!empty($wheres))
			$countfilter = $this->bonrec_dechet->queryFirst($sqlcount . " WHERE " . implode(" AND ", $wheres));
		else
			$countfilter = $count;
		
		// CONSTRUCTION DE LA REQUETE.
		$fields = $this->datatable_columns($_GET);
		$sql = "SELECT " . implode(" , ", $fields) . " FROM bonrec_dechet B left join patient_had P ON numpat=P.ext_patient ";
		if (!empty($wheres))
			$sql .= " WHERE " . implode(" AND ", $wheres);
		$sql .= $this->datatable_order_offset($_GET, $fields);
		
		// EXECUTION DE LA REQUETE.
		$elements = $this->bonrec_dechet->query($sql, PDO::FETCH_NUM);
		
		// MISE EN FORME DES DONNEES ET AJOUT DES OPTIONS.
		$indcode = array_search('numbrdec', $fields);
		$inddatdem = array_search('datdem', $fields);
		$inddatrec = array_search('datrec', $fields);
		$inddatenvmail = array_search('datenvmail', $fields);
		$indstatut = array_search('B.statut', $fields);
		
		foreach ($elements as $k => $element) {
			
			$element[$inddatdem]=  datevershtml($element[$inddatdem]);
			$element[$inddatrec] = datevershtml($element[$inddatrec]);
			$element[$inddatenvmail] = datevershtml($element[$inddatenvmail]);

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
	public function liste($rp_numbrdec='', $rp_datdem='', $rp_datrec='') {

	// valeur par defaut des recherches
		$r_bonrec_dechet = array(
			'r_numbrdec' => '',
			'r_lb_nom' => '',
			'r_datdem' => '',
			'r_datrec' => '',
			'r_statut' => 'A'			
		);
		
		// integration des paramétres
		if ($rp_numbrdec!='*')
			$_SESSION ['r_bonrec_dechet']['r_numbrdec']=$rp_numbrdec;
		
		if ($rp_datdem!='*'){
			$rp_datdem = str_replace('-', '/', $rp_datdem);
			$_SESSION ['r_bonrec_dechet']['r_datdem']=$rp_datdem;
		}
		if ($rp_datrec!='*'){
			$rp_datrec = str_replace('-', '/', $rp_datrec);
			$_SESSION ['r_bonrec_dechet']['r_datrec']=$rp_datrec;
		}
		
		if (isset($_SESSION ['r_bonrec_dechet']))
			$r_bonrec_dechet = array_copie($r_bonrec_dechet, $_SESSION ['r_bonrec_dechet']);
		if (isset($_POST))
			$r_bonrec_dechet = array_copie($r_bonrec_dechet, $_POST);
		
// sauvegarde en session de la recherche
		$_SESSION ['r_bonrec_dechet'] = $r_bonrec_dechet;

		// initialisation des variables ecrans....
		$this->smarty->assign('r_bonrec_dechet', $r_bonrec_dechet);
		$this->affiche('list');
	}
	/**
	 * ********************************************
	 * Desactiver
	 * *********************************************
	 */
	public function desactiver($numbrdec) {
		if (isset($numbrdec)) {
			$this->bonrec_dechet->update('numbrdec', $numbrdec, array(
				'statut' => 'D'
			));
		}
	}
	/**
	 * ********************************************
	 * Activer
	 * *********************************************
	 */
	public function activer($numbrdec) {
		if (isset($numbrdec)) {
			$this->bonrec_dechet->update('numbrdec', $numbrdec, array(
				'statut' => 'A'
			));
		}
	}
	/**
	 * ********************************************
	 * Affichage enregistrement à modifier
	 * *********************************************
	 */
	public function modifier($numbrdec) {
		
		if (isset($numbrdec)) {
			
			// Lecture enregistrement
			$element = $this->bonrec_dechet->find('numbrdec', $numbrdec);
			$element['hide_numbrdec'] = $element['numbrdec'];
			
			// si pas trouve alors on revient sur la liste
			if ($element) {				
				$element['datdem'] = datevershtml($element['datdem']);
				$element['datrec'] = datevershtml($element['datrec']);
		
				$this->zones_page($element);
				$this->affiche('form');
			} else {
				$this->redirect($_SESSION['page_prec']);
			}
		}
	}
	/**
	 * ********************************************
	 * Zones page
	 * *********************************************
	 */
	public function zones_page($element) {
		
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
	}
	/**
	 * *********************************************
	 * Affichage enregistrement vide pour ajout
	 * *********************************************
	 */
	public function ajouter($numcde) {
		
		$element = $this->bonrec_dechet->emptyRecord();
		
		$element ['hide_numbrdec']='';
		
		$element ['datdem'] = date('d/m/Y');
		$element ['nomdem'] = auth::$auth ['prenom'].' '.auth::$auth ['nom'];
		$element ['jrsrec'] = 'DJ' ;
		$element ['r_maison'] = 'O' ;
		$element ['r_rdc'] = 'O' ;
		$element ['r_ascen'] = 'N' ;
			
		$boncde_entete = $this->boncde_entete->find('numcde', $numcde);
		$element ['numpat']=$boncde_entete['numpat'];
		
		$dernum = $this->bonrec_dechet->queryFirst("SELECT max(substr(numbrdec,17,2)) as nummax FROM bonrec_dechet WHERE sk_client=:sk_client AND numbrdec like '".$numcde."_D%'", array('sk_client' => auth::$auth ['sk_client']));		
		$element['numbrdec'] = $numcde  . '_D' . sprintf ( "%1$02d", ($dernum['nummax']+1));					
	
		$element['sk_client'] = auth::$auth ['sk_client'];		
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
			
			$_POST ['r_dechet'] = (isset($_POST ['r_dechet']) && $_POST ['r_dechet'] == 'on') ? 'O' : 'N';
			$_POST ['r_conso'] = (isset($_POST ['r_conso']) && $_POST ['r_conso'] == 'on' ) ? 'O' : 'N';
			$_POST ['r_medic'] = (isset($_POST ['r_medic']) && $_POST ['r_medic'] == 'on' ) ? 'O' : 'N';
			
			$_POST ['jrsrec'] = isset($_POST ['jrsrec']) ?  $_POST ['jrsrec'] : 'DJ' ;
			
			$_POST ['r_maison'] = isset($_POST ['r_maison']) ?  $_POST ['r_maison'] : 'O' ;
			$_POST ['r_rdc'] = isset($_POST ['r_rdc']) ?  $_POST ['r_rdc'] : 'O' ;
			$_POST ['r_ascen'] = isset($_POST ['r_ascen']) ?  $_POST ['r_ascen'] : 'N' ;
			
			$hide_numbrdec = $_POST ['hide_numbrdec'];
			$numbrdec = $_POST ['numbrdec'];
	
			//====================================
			// Controle de la saisie
			//====================================
			// Date de demande
			if (empty($_POST ['datdem'])) {
				$this->message('Vous devez entrer une date de demande de déchet', 'error');
				$this->zones_page($_POST);
				$this->affiche("form");
				return;
			}
			// Date de récupération souhaitée
			if (empty($_POST ['datrec'])) {
				$this->message('Vous devez entrer une date de récupération déchet', 'error');
				$this->zones_page($_POST);
				$this->affiche("form");
				return;
			}
			// si étage alors ascenseur obligatoire
			if ($_POST ['r_rdc']== 'O' && $_POST ['r_ascen']== 'O') {
				$this->message('Incohérence RDC avec ascenseur', 'error');
				$this->zones_page($_POST);
				$this->affiche("form");
				return;
			}
	
			// saisie valide -> mise à jour base
			$_POST['datrec'] =  dateverssql($_POST['datrec']);
			$_POST['datdem'] =  dateverssql($_POST['datdem']);
			
			if (empty($hide_numbrdec)) {
				// INSERT
				$_POST['sk_client'] = auth::$auth ['sk_client'];
				
				$this->bonrec_dechet->insert($_POST);
				$this->redirect($_SESSION['page_prec']);
				$this->message("Le bon de récupération déchet a été ajouté avec succés", "normal");
			} else {
				// UPDATE
				$this->bonrec_dechet->update('numbrdec', $numbrdec, $_POST);
				$this->redirect($_SESSION['page_prec']);
				$this->message("Le bon de récupération déchet a été modifié avec succés", "normal");
			}
		}else{
			$this->redirect($_SESSION['page_prec']);
		}
		unset($_POST);	
	}
	
	public function envmailbrdec($numbrdec = '*', $retour = true) {
		$this -> mailbrdec($numbrdec, $retour);	
		$this->redirect($_SESSION['page_prec']);
	}
	public function mailbrdec($numbrdec = '*', $retour = true) {

		if (isset($numbrdec) || $numbrdec != '*') {
			
			// Lecture enregistrement
			$bonrec = $this->bonrec_dechet->find('numbrdec', $numbrdec);
			if ($bonrec) {
				
				$bonrec['datdem'] = datevershtml($bonrec['datdem']);
				$bonrec['datrec'] = datevershtml($bonrec['datrec']);			
				$this->smarty->assign('bonrec', $bonrec);
				
				$client = $this->client_had->findOrEmpty('sk_client', $bonrec['sk_client']);
				$this->smarty->assign('client', $client);
				
				$utilisateur = $this->utilisateur->findOrEmpty('coduti', auth::$auth['coduti']);
				$this->smarty->assign('utilisateur', $utilisateur);
				
				$patient = $this->patient_had->findOrEmpty('ext_patient', $bonrec['numpat']);
				$this->smarty->assign('patient', $patient);
							
				$message = $this->smarty->fetch(BASE_DIR . "pages/mailbonrdec.html");
	
				$mail = new mail();
				$mail->setFrom("ExtranetHAD@bastide-medical.fr");
				$mail->addAddress($client['lb_mail_gest1']);
				$mail->addAddress($client['lb_mail_gest2']);
				$mail->Subject = "[EXTRANET HAD] - Enregistrement du bon de récupération déchet n° " . $numbrdec ;
				$mail->msgHTML($message);
				$mail->sendEmail();
				
				// UPDATE
				$this->bonrec_dechet->update('numbrdec', $numbrdec, array('datenvmail'=>date('Y-m-d'), 'hrsenvmail' => date('H:i:s')));
				
				if ($retour)	
					return true;
			}
		}
		if ($retour)
			return false;
		$this->redirect("/bonrdec");
	}

}
