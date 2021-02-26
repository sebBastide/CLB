<?php

class bonrmatCtrl extends Controller {

	public $smarty;
	public $bonrec_materiel;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->boncde_entete = new dbtable('boncde_entete');
		$this->bonrec_materiel = new dbtable('bonrec_materiel');
		$this->bonrec_poste = new dbtable('bonrec_poste');
		$this->boncde_poste = new dbtable('boncde_poste');
		$this->produit_had = new dbtable('produit_had');
		$this->client_had = new dbtable('client_had');
		$this->patient_had = new dbtable('patient_had');
		$this->raison_had = new dbtable('raison_had');
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
			$this->smarty->displayLayout('bonrmat/fiche.tpl', 'Bon de récupération matériel');
		} elseif ($page_a_afficher == "list") {
			$this->smarty->displayLayout('bonrmat/liste.tpl', 'Liste des bons de récupérations matériels');
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
		
		$r_bonrec_materiel = $_SESSION ['r_bonrec_materiel'];
		
		// CONSTRUCTION DU WHERE
		$wheres = array();
		
		if (isset($r_bonrec_materiel['r_statut']) && $r_bonrec_materiel ['r_statut'] != 'T'&& $r_bonrec_materiel ['r_statut'] != 'H')
			$wheres [] = "B.statut='" . $r_bonrec_materiel ['r_statut'] . "' AND B.datfinhad='0000-00-00'";
		
		if (isset($r_bonrec_materiel['r_statut']) && $r_bonrec_materiel ['r_statut'] == 'H')
			$wheres [] = "B.datfinhad<>'0000-00-00'";
		
		if (isset($r_bonrec_materiel ['r_numbrmat']) && !empty($r_bonrec_materiel ['r_numbrmat']))
			$wheres [] = "numbrmat='" . sql_escape($r_bonrec_materiel ['r_numbrmat']) . "'";
		
		if (isset($r_bonrec_materiel ['r_numpat']) && !empty($r_bonrec_materiel ['r_numpat']))
			$wheres [] = "numpat='" . sql_escape($r_bonrec_materiel ['r_numpat']) . "'";
		
		if (isset($r_bonrec_materiel ['r_datdem']) && !empty($r_bonrec_materiel ['r_datdem']))
			$wheres [] = " datdem = '" . sql_escape(dateverssql ($r_bonrec_materiel ['r_datdem'])) . "'";
		
		if (isset($r_bonrec_materiel ['r_datrec']) && !empty($r_bonrec_materiel ['r_datrec']))
			$wheres [] = " datrec = '" . sql_escape(dateverssql ($r_bonrec_materiel ['r_datrec'])) . "'";
		
		if (isset($r_bonrec_materiel ['r_lb_nom']) && !empty($r_bonrec_materiel ['r_lb_nom']))
			$wheres [] = " lb_nom like '%" . sql_escape($r_bonrec_materiel ['r_lb_nom']) . "%'";
		
		// Restriction aux bonrec_materiel
		if (auth::$auth ['grputi']!="A") {
			$wheres [] = "B.sk_client  = '" . auth::$auth ['sk_client'] . "'";
		}
		
		// RECUP. DU NOMBRE TOTAL D'ENREG.
		$sqlcount = "SELECT COUNT(*) AS CPT FROM bonrec_materiel B";
		$count = $this->bonrec_materiel->queryFirst($sqlcount);
		
		// RECUP. DU NOMBRE D'ENREG. FILTRES.
		if (!empty($wheres))
			$countfilter = $this->bonrec_materiel->queryFirst($sqlcount . " WHERE " . implode(" AND ", $wheres));
		else
			$countfilter = $count;
		
		// CONSTRUCTION DE LA REQUETE.
		$fields = $this->datatable_columns($_GET);
		$sql = "SELECT " . implode(" , ", $fields) . " FROM bonrec_materiel B left join patient_had P ON numpat=P.ext_patient ";
		if (!empty($wheres))
			$sql .= " WHERE " . implode(" AND ", $wheres);
		$sql .= $this->datatable_order_offset($_GET, $fields);
		
		// EXECUTION DE LA REQUETE.
		$elements = $this->bonrec_materiel->query($sql, PDO::FETCH_NUM);
		
		// MISE EN FORME DES DONNEES ET AJOUT DES OPTIONS.
		$indcode = array_search('numbrmat', $fields);
		$inddatdem = array_search('datdem', $fields);
		$inddatrec = array_search('datrec', $fields);
		$inddatfinhad = array_search('datfinhad', $fields);
		$inddatenvmail = array_search('datenvmail', $fields);
		$indstatut = array_search('B.statut', $fields);
		
		foreach ($elements as $k => $element) {
			
			$element[$inddatdem]=  datevershtml($element[$inddatdem]);
			$element[$inddatrec] = datevershtml($element[$inddatrec]);
			$element[$inddatfinhad] = datevershtml($element[$inddatfinhad]);
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
	public function liste($rp_numbrmat='', $rp_datdem='', $rp_datrec='') {

	// valeur par defaut des recherches
		$r_bonrec_materiel = array(
			'r_numbrmat' => '',
			'r_numpat' => '',
			'r_lb_nom' => '',
			'r_datdem' => '',
			'r_datrec' => '',
			'r_statut' => 'A'			
		);
		
		// integration des paramétres
		if ($rp_numbrmat!='*')
			$_SESSION ['r_bonrec_materiel']['r_numbrmat']=$rp_numbrmat;
		
		if ($rp_datdem!='*'){
			$rp_datdem = str_replace('-', '/', $rp_datdem);
			$_SESSION ['r_bonrec_materiel']['r_datdem']=$rp_datdem;
		}
		if ($rp_datrec!='*'){
			$rp_datrec = str_replace('-', '/', $rp_datrec);
			$_SESSION ['r_bonrec_materiel']['r_datrec']=$rp_datrec;
		}
			
		if (isset($_SESSION ['r_bonrec_materiel']))
			$r_bonrec_materiel = array_copie($r_bonrec_materiel, $_SESSION ['r_bonrec_materiel']);
		if (isset($_POST))
			$r_bonrec_materiel = array_copie($r_bonrec_materiel, $_POST);
		
		// sauvegarde en session de la recherche
		$_SESSION ['r_bonrec_materiel'] = $r_bonrec_materiel;

		// initialisation des variables ecrans....
		$this->smarty->assign('r_bonrec_materiel', $r_bonrec_materiel);
		$this->affiche('list');
	}
	/**
	 * ********************************************
	 * Desactiver
	 * *********************************************
	 */
	public function desactiver($numbrmat) {
		if (isset($numbrmat)) {
			$this->bonrec_materiel->update('numbrmat', $numbrmat, array(
				'statut' => 'D'
			));
		}
	}
	/**
	 * ********************************************
	 * Activer
	 * *********************************************
	 */
	public function activer($numbrmat) {
		if (isset($numbrmat)) {
			$this->bonrec_materiel->update('numbrmat', $numbrmat, array(
				'statut' => 'A'
			));
		}
	}
	/**
	 * ********************************************
	 * Affichage enregistrement à modifier
	 * *********************************************
	 */
	public function modifier($numbrmat) {
		
		if (isset($numbrmat)) {
			
			// Lecture enregistrement
			$element = $this->bonrec_materiel->find('numbrmat', $numbrmat);
			$element['hide_numbrmat'] = $element['numbrmat'];
			$element['hide_datfinhad'] = $element['datfinhad'];
			
			// si pas trouve alors on revient sur la liste
			if ($element) {				
				$element['datdem'] = datevershtml($element['datdem']);
				$element['datrec'] = datevershtml($element['datrec']);
				$element['datfinhad'] = datevershtml($element['datfinhad']);
				$element['passsad'] = datevershtml($element['passsad']);		
											
				// Lecture enregistrement
				$numcde = mb_substr($numbrmat,0,14) ;
				/*$groupes = $this->bonrec_poste->query(" select distinct(lb_hierachie) "
					                        . " from produit_had "
											. " where sk_client=:sk_client and sk_produit in "
											. " (select sk_produit from boncde_poste where numcde = '". $numcde."' and statut='A' and qt_produit<>0 ) "
											. " AND sk_produit not in (select sk_produit from bonrec_poste where numbrmat LIKE '". $numcde."%' and numbrmat<>'".$numbrmat."') " 
											. " order by lb_hierachie ", array('sk_client' => auth::$auth ['sk_client']));*/
											
				$groupes = $this->bonrec_poste->query(" select distinct(lb_hierachie) "
				. " from produit_had "
				. " where sk_client=:sk_client and sk_produit in "
				. " (select sk_produit from boncde_poste where numbrmat ='".$numbrmat."' and statut='A' and qt_produit<>0 ) "
				. " AND sk_produit not in (select sk_produit from bonrec_poste where numbrmat like '". $numcde."%' AND numbrmat<>'".$numbrmat. "') " 
				. " order by lb_classement,lb_hierachie ", array('sk_client' => auth::$auth ['sk_client']));							
				
				$arecup=array();
				if ($groupes) {

					foreach ($groupes as $k => $groupe) {
						
						/*$groupe['produits'] = $this->bonrec_poste->query("SELECT CASE WHEN P.lb_produit = '' THEN B.co_produit ELSE P.lb_produit END as lb_produit, P.sk_produit, B.qt_produit, R.arecup, numbrmat"
								. " FROM produit_had P LEFT JOIN boncde_poste B ON P.sk_produit = B.sk_produit "
								. " LEFT JOIN bonrec_poste R ON B.sk_produit = R.sk_produit and numbrmat='".$numbrmat ."'"
								. " WHERE numcde = '". $numcde."' AND lb_hierachie='" . $groupe['lb_hierachie']. "' AND P.sk_client=:sk_client "
								. " AND B.sk_produit not in (select sk_produit from bonrec_poste where numbrmat LIKE '". $numcde."%'and numbrmat<>'".$numbrmat."') " 
								. " order by lb_classement,P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));*/
								
						$groupe['produits'] = $this->bonrec_poste->query("SELECT DISTINCT CASE WHEN P.lb_produit = '' THEN B.co_produit ELSE P.lb_produit END as lb_produit, P.sk_produit, B.qt_produit, R.arecup, numcde, concat(P.sk_produit,concat('*',numcde)) as produitCommande"
						. " FROM produit_had P LEFT JOIN boncde_poste B ON P.sk_produit = B.sk_produit "
						. " LEFT JOIN bonrec_poste R ON B.sk_produit = R.sk_produit AND B.numbrmat ='". $numbrmat."' "
						. " WHERE lb_hierachie='" . $groupe['lb_hierachie']. "' AND P.sk_client=:sk_client AND R.numbrmat ='". $numbrmat."' "
						. " order by lb_classement,P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						
						foreach ($groupe['produits'] as $produit) 
						{
							$arecup[$produit['produitCommande']]= $produit['arecup'];
						}
						$groupes[$k]=$groupe;
						
					}
				}
				
				$element['groupes']=$groupes;
				$element['arecup']=$arecup;	
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
	 public function zones_page_Multi($element) {
		
		$element['rech_patient_had'] = "";
		
		if (isset($element['numpat'])) {
			$patient_had = $this->patient_had->find('ext_patient', $element['numpat']);
			if (!$patient_had)
			{
				$patient_had = $this->patient_had->emptyRecord();
			}	
		}else {
			$patient_had = $this->patient_had->emptyRecord();
		}
		$this->smarty->assign('patient_had', $patient_had);
		/*for ($i = 1; $i <= 10; $i++) 
		{		
			if (isset($id_commande[$i]))
			{	
				$this->smarty->assign('groupes', $element['groupes'][$i]);
				$this->smarty->assign('arecup', $element['arecup'][$i]);
			}
		}
		*/
		$this->smarty->assign('groupes', $element['groupes']);
		$this->smarty->assign('arecup', $element['arecup']);
		$this->smarty->assign('raisons', $this->raison_had->listeactifs("raison_had", "librai,codrai"));
		
		$this->smarty->assign('element', $element);
	}
	
	public function zones_page($element) {
		
		$element['rech_patient_had'] = "";
		
		if (isset($element['numpat'])) {
			$patient_had = $this->patient_had->find('ext_patient', $element['numpat']);
			if (!$patient_had)
			{
				$patient_had = $this->patient_had->emptyRecord();
			}
		}else {
			$patient_had = $this->patient_had->emptyRecord();
		}
		$this->smarty->assign('patient_had', $patient_had);
		$this->smarty->assign('groupes', $element['groupes']);
		$this->smarty->assign('arecup', $element['arecup']);
		$this->smarty->assign('raisons', $this->raison_had->listeactifs("raison_had", "librai,codrai"));
		
		$this->smarty->assign('element', $element);
	}
	/**
	 * *********************************************
	 * Affichage enregistrement vide pour ajout
	 * *********************************************
	 */
	 public function ajouter_Multi() {
		$element = $this->bonrec_materiel->emptyRecord();
		$element ['hide_numbrmat']='';
		$element['hide_datfinhad'] = 0;
		
		$element ['datdem'] = date('d/m/Y');
		$element ['nomdem'] = auth::$auth ['prenom'].' '.auth::$auth ['nom'];
		
		$element ['jrsrec'] = 'DJ' ;
		
		$element ['r_maison'] = 'O' ;
		$element ['r_rdc'] = 'O' ;
		$element ['r_ascen'] = 'N' ;
		
		$i=0;		
		$arecup=array();
		$numbrmatarr=array();
		$id_commande=array();
		$id_produit=array();
		//for ($i = 1; $i <= 10; $i++) {
		//	if (isset ($_GET['id_commande'][intval($i)]))
		//	{
				//$id_commande[$i] = $_GET['id_commande'][intval($i)];
				//$id_produit[$i] = $_GET['id_produit'][intval($i)];
				
				
				// Calcul numero de bon de récup : attention si plusieurs bons de commande, on prend le dernier bon
				$numCdeMulti = explode(",", $_GET['id_commande']);
				//tri par dernier numéro de commande
				rsort($numCdeMulti);
				
				$boncde_entete = $this->boncde_entete->find('numcde', str_replace("'","",$numCdeMulti[0]));
				$element['numpat']=$boncde_entete['numpat'];
				
				$dernum = $this->bonrec_materiel->queryFirst("SELECT max(substr(numbrmat,17,2)) as nummax FROM bonrec_materiel WHERE sk_client=:sk_client AND numbrmat like '".$numCdeMulti[0]."_M%'", array('sk_client' => auth::$auth ['sk_client']));		
				$element['numbrmat'] = str_replace("'","",$numCdeMulti[0]) . '_M' . sprintf ( "%1$02d", ($dernum['nummax']+1));
				$element['hide_numbrdec']='';
				$element['sk_client'] = auth::$auth ['sk_client'];
				
				// Lecture enregistrement pour détailler les hierarchies
				$groupes = $this->bonrec_poste->query(" select distinct(lb_hierachie) "
				. " from produit_had "
				. " where sk_client=:sk_client and sk_produit in "
				. " (select sk_produit from boncde_poste where numcde in (". $_GET['id_commande'].") and statut='A' and qt_produit<>0 ) AND sk_produit IN (".$_GET['id_produit']. ")"
				//. " AND sk_produit not in (select sk_produit from bonrec_poste where LEFT(numbrmat,14) IN (". $_GET['id_commande'].")) "
				. " order by lb_classement,lb_hierachie ", array('sk_client' => auth::$auth ['sk_client']));
				if ($groupes) 
				{		   
					foreach ($groupes as $k => $groupe) 
					{						
						$groupe['produits'] = $this->bonrec_poste->query("SELECT distinct CASE WHEN P.lb_produit = '' THEN B.co_produit ELSE P.lb_produit END as lb_produit, P.sk_produit, B.qt_produit, R.arecup, numcde, concat(P.sk_produit,concat('*',numcde)) as produitCommande"
						. " FROM produit_had P LEFT JOIN boncde_poste B ON P.sk_produit = B.sk_produit "
						. " LEFT JOIN bonrec_poste R ON B.sk_produit = R.sk_produit AND LEFT(R.numbrmat,14) IN (". $_GET['id_commande'].") "
						. " WHERE numcde in (". $_GET['id_commande'].") AND lb_hierachie='" . $groupe['lb_hierachie']. "' AND P.sk_client=:sk_client AND B.sk_produit IN (".$_GET['id_produit']. ")"
						//. " AND B.sk_produit not in (select sk_produit from bonrec_poste where LEFT(numbrmat,14) IN (". $_GET['id_commande'].")) "
						. " order by lb_classement,P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						
						foreach ($groupe['produits'] as $produit) 
						{
							$arecup[$produit['produitCommande']]= $produit['arecup'];
						}
						$groupes[$k]=$groupe;
					}	   
				}
				$element['arecup']=$arecup;	
				$element['groupes']=$groupes;
		//	}			
		//}
		
		$this->zones_page_Multi($element);				
		$this->affiche("form");
	 }
	
	public function ajouter($numcde) {
		
		$element = $this->bonrec_materiel->emptyRecord();
		$element ['hide_numbrmat']='';
		$element['hide_datfinhad'] = 0;
		
		$element ['datdem'] = date('d/m/Y');
		$element ['nomdem'] = auth::$auth ['prenom'].' '.auth::$auth ['nom'];
		
		$element ['jrsrec'] = 'DJ' ;
		
		$element ['r_maison'] = 'O' ;
		$element ['r_rdc'] = 'O' ;
		$element ['r_ascen'] = 'N' ;
		
		$boncde_entete = $this->boncde_entete->find('numcde', $numcde);
		$element ['numpat']=$boncde_entete['numpat'];
		
		$dernum = $this->bonrec_materiel->queryFirst("SELECT max(substr(numbrmat,17,2)) as nummax FROM bonrec_materiel WHERE sk_client=:sk_client AND numbrmat like '".$numcde."_M%'", array('sk_client' => auth::$auth ['sk_client']));		
		$element['numbrmat'] = $numcde  . '_M' . sprintf ( "%1$02d", ($dernum['nummax']+1));					
		$element ['hide_numbrdec']='';
		
		$element['sk_client'] = auth::$auth ['sk_client'];
		
		// Lecture enregistrement
		$groupes = $this->bonrec_poste->query(" select distinct(lb_hierachie) "
					                        . " from produit_had "
											. " where sk_client=:sk_client and sk_produit in "
											. " (select sk_produit from boncde_poste where numcde = '". $numcde."' and statut='A' and qt_produit<>0 ) "
											. " AND sk_produit not in (select sk_produit from bonrec_poste where numbrmat LIKE '". $numcde."%') "
											. " order by lb_classement,lb_hierachie ", array('sk_client' => auth::$auth ['sk_client']));
		$arecup=array();
		$numbrmatarr=array();
		if ($groupes) {
   
		   
			foreach ($groupes as $k => $groupe) {
						
						$groupe['produits'] = $this->bonrec_poste->query("SELECT CASE WHEN P.lb_produit = '' THEN B.co_produit ELSE P.lb_produit END as lb_produit, P.sk_produit, B.qt_produit, R.arecup, numcde as numbrmat "
								. " FROM produit_had P LEFT JOIN boncde_poste B ON P.sk_produit = B.sk_produit "
								. " LEFT JOIN bonrec_poste R ON B.sk_produit = R.sk_produit AND numbrmat LIKE '". $numcde."_%' "
								. " WHERE numcde = '". $numcde."' AND lb_hierachie='" . $groupe['lb_hierachie']. "' AND P.sk_client=:sk_client "
								. " AND B.sk_produit not in (select sk_produit from bonrec_poste where numbrmat LIKE '". $numcde."_%') "
								. " order by lb_classement,P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						
						foreach ($groupe['produits'] as $produit) {
							$arecup[$produit['sk_produit']]= $produit['arecup'];
							$numbrmatarr[$k]=$produit['numbrmat'];
						}
						$groupes[$k]=$groupe;
						
					}
		   
			}

		$element['arecup']=$arecup;	
		$element['groupes']=$groupes;
		$element['numbrmatarr']=$numbrmatarr;	
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
			$verifCasesAcocher=0;
			$toto = 0;
			$tata = 0;
			if (isset($_POST['arecup'])) { 
				foreach($_POST['arecup'] as $k=>$arecup){
					if(isset($_POST ['arecup'][$k]))
					{
						//$_POST ['arecup'][$k] = (isset($arecup) && $arecup == 'on') ? 1 : 0;
						$_POST ['arecup'][$k] = 1;
						$verifCasesAcocher=1;
						$toto = $toto+1;
					}
					else
					{
						$_POST ['arecup'][$k] = 0;
						$tata = $tata + 1 ;
					}					
				}
			}else{
				$_POST['arecup']=array(); 
			}
			
			$_POST ['r_materiel'] = (isset($_POST ['r_materiel']) && $_POST ['r_materiel'] == 'on') ? 'O' : 'N';
			$_POST ['r_dossoins'] = (isset($_POST ['r_dossoins']) && $_POST ['r_dossoins'] == 'on' ) ? 'O' : 'N';
			$_POST ['r_malchimio'] = (isset($_POST ['r_malchimio']) && $_POST ['r_malchimio'] == 'on' ) ? 'O' : 'N';
			$_POST ['r_conso'] = (isset($_POST ['r_conso']) && $_POST ['r_conso'] == 'on' ) ? 'O' : 'N';
			$_POST ['r_medic'] = (isset($_POST ['r_medic']) && $_POST ['r_medic'] == 'on' ) ? 'O' : 'N';
			$_POST ['r_dechet'] = (isset($_POST ['r_dechet']) && $_POST ['r_dechet'] == 'on' ) ? 'O' : 'N';
			
			$_POST ['jrsrec'] = isset($_POST ['jrsrec']) ?  $_POST ['jrsrec'] : 'DJ' ;
			
			$_POST ['r_maison'] = isset($_POST ['r_maison']) ?  $_POST ['r_maison'] : 'O' ;
			$_POST ['r_rdc'] = isset($_POST ['r_rdc']) ?  $_POST ['r_rdc'] : 'O' ;
			$_POST ['r_ascen'] = isset($_POST ['r_ascen']) ?  $_POST ['r_ascen'] : 'N' ;
			
			$hide_numbrmat = $_POST ['hide_numbrmat'];
			$numbrmat = $_POST ['numbrmat'];
	
			//====================================
			// Controle de la saisie
			//====================================
			// Cases à cocher
			if ($verifCasesAcocher==0)
			{
				$this->message('Vous devez sélectionner au moins un produit', 'error');
				$this->zones_page_Multi($_POST);
				//$this->redirect($_SERVER['REQUEST_URI']); 
				$this->affiche("form");
				return;
			}
			// Date de demande
			if (empty($_POST ['datdem'])) {
				$this->message('Vous devez entrer une date de demande de matériel', 'error');
				$this->zones_page($_POST);
				$this->affiche("form");
				return;
			}
			if (!empty($_POST ['datfinhad']) && empty($_POST ['raifinhad'])) {
				$this->message('Vous devez entrer une raison pour la fin du HAD', 'error');
				$this->zones_page($_POST);
				$this->affiche("form");
				return;
			}
			// Date de récupération souhaitée
			/* if (empty($_POST ['datrec'])) {
				$this->message('Vous devez entrer une date de récupération matériel', 'error');
				$this->zones_page($_POST);
				$this->affiche("form");
				return;
			}*/
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
			$_POST['datfinhad'] = dateverssql($_POST['datfinhad']);
			$_POST['passsad'] = dateverssql($_POST['passsad']);
			
			if (empty($_POST ['datfinhad']) && !empty($_POST ['raifinhad'])) {
				$_POST ['raifinhad']="";
			}
			
			if (empty($hide_numbrmat)) 
			{
				// INSERT
				$_POST['sk_client'] = auth::$auth ['sk_client'];
				
				$this->bonrec_materiel->insert($_POST);
				
				// Mise à jour de 
				//$this->bonrec_poste->delete('numbrmat', $_POST['numbrmat'], $_POST);
				
				// Mise à jout des quantités	
				foreach ($_POST['arecup'] as $k=>$arecup) 
				{					
					$produitEtCommande = explode("*",$k);
					// table bonrec_poste
					$this->bonrec_poste->insert(array(
						'sk_client'=> $_POST['sk_client'], 
						'numbrmat'=> $_POST['numbrmat'], 
						'sk_produit'=>$produitEtCommande[0],
						'lb_produit'=>$this->bonrec_poste->recuplib('produit_had','sk_produit', $produitEtCommande[0], 'lb_produit'),
						'arecup'=>1));
					
					// table boncde_poste : maj du numbrmat en fonction du produit (numcde et FKL)
					$this->boncde_poste->query("UPDATE boncde_poste SET numbrmat='".$_POST['numbrmat']."' WHERE sk_produit='".$produitEtCommande[0]."' and numcde='".$produitEtCommande[1]."'");				
				}				
				// MAj bon de commande + autre bon recup mat.
				if ($_POST['datfinhad'] != 0) {
					$numcde = mb_substr($_POST ['numbrmat'],0,14) ;
					$this->boncde_entete->query("UPDATE boncde_entete set datfinhad='".$_POST['datfinhad']."', raifinhad='".$_POST ['raifinhad']."' where sk_client='".$_POST['sk_client']."' AND numcde='".$numcde."'");
					$this->bonrec_materiel->query("UPDATE bonrec_materiel set datfinhad='".$_POST['datfinhad']."', raifinhad='".$_POST ['raifinhad']."' where sk_client='".$_POST['sk_client']."' AND numbrmat like '".$numcde."_%'");	
				}
					
				$this->envmailbrmat($_POST['numbrmat'],true);
				$this->redirect($_SESSION['page_prec']);
				
				$this->message("Le bon de récupération matériel a été ajouté avec succés ", "normal");
			} else {
				// UPDATE
				$this->bonrec_materiel->update('numbrmat', $_POST['numbrmat'], $_POST);
				
				// Mise à jour de 
				$this->bonrec_poste->delete('numbrmat', $_POST['numbrmat'], $_POST);
				
				// table boncde_poste : maj du numbrmat en fonction du produit (numcde et FKL), remise à zéro avant nouveau remplissage
				$this->boncde_poste->query("UPDATE boncde_poste SET numbrmat=null WHERE numbrmat='".$_POST['numbrmat']."'");	
					
				foreach ($_POST['arecup'] as $k=>$arecup) 
				{				
					$produitEtCommande = explode("*",$k);
					// table bonrec_poste
					$this->bonrec_poste->insert(array(
						'sk_client'=> auth::$auth ['sk_client'], 
						'numbrmat'=> $_POST['numbrmat'], 
						'sk_produit'=>$produitEtCommande[0],
						'lb_produit'=>$this->bonrec_poste->recuplib('produit_had','sk_produit', $produitEtCommande[0], 'lb_produit'),
						'arecup'=>1));
										
					// table boncde_poste : maj du numbrmat en fonction du produit (numcde et FKL)
					$this->boncde_poste->query("UPDATE boncde_poste SET numbrmat='".$_POST['numbrmat']."' WHERE sk_produit='".$produitEtCommande[0]."' and numcde='".$produitEtCommande[1]."'");				
					
				}
				$this->envmailbrmat($hide_numbrmat,true);
				$this->redirect($_SESSION['page_prec']);
				$this->message("Le bon de récupération matériel a été modifié avec succés ", "normal");
			}
		}else{
			$this->redirect($_SESSION['page_prec']);
		}
		unset($_POST);	
	}

	public function envmailbrmat($numbrmat = '*', $retour = true) {
		$this -> mailbrmat($numbrmat, $retour);	
		$this->redirect($_SESSION['page_prec']);
	}
	
	public function mailbrmat($numbrmat = '*', $retour = true) {

		if (isset($numbrmat) || $numbrmat != '*') {
			
			// Lecture enregistrement
			$bonrec = $this->bonrec_materiel->find('numbrmat', $numbrmat);
			if ($bonrec) {				
				$bonrec['datdem'] = datevershtml($bonrec['datdem']);
				$bonrec['datrec'] = datevershtml($bonrec['datrec']);
				$bonrec['datfinhad'] = datevershtml($bonrec['datfinhad']);	
				$this->smarty->assign('bonrec', $bonrec);

				$raison = $this->raison_had->findOrEmpty('codrai', $bonrec['raifinhad']);
				$this->smarty->assign('raison', $raison);

				$client = $this->client_had->findOrEmpty('sk_client', $bonrec['sk_client']);
				$this->smarty->assign('client', $client);
				
				$utilisateur = $this->utilisateur->findOrEmpty('coduti', auth::$auth['coduti']);
				$this->smarty->assign('utilisateur', $utilisateur);
				
				$patient = $this->patient_had->findOrEmpty('ext_patient', $bonrec['numpat']);
				$this->smarty->assign('patient', $patient);
				
				// liste des produits récupérés
				/*$groupes = $this->bonrec_poste->query(" select distinct(lb_hierachie) "
													. " from bonrec_poste B left join produit_had P ON P.sk_produit = B.sk_produit "
													. " where B.sk_client=:sk_client and numbrmat=:numbrmat order by lb_classement ", array('sk_client' => auth::$auth ['sk_client'], 'numbrmat' => $numbrmat)); */
				/*$groupes = $this->bonrec_poste->query(" select distinct(lb_hierachie) "
													. " from bonrec_poste B left join produit_had P ON P.sk_produit = B.sk_produit "
													. " where B.sk_client=:sk_client and numbrmat=:numbrmat order by lb_hierachie ", array('sk_client' => auth::$auth ['sk_client'], 'numbrmat' => $numbrmat));	*/														
				$groupes = $this->bonrec_poste->query(" select distinct(lb_hierachie) "
													. " from boncde_poste B left join produit_had P ON P.sk_produit = B.sk_produit "
													. " where B.sk_client=:sk_client and numbrmat=:numbrmat order by lb_hierachie ", array('sk_client' => auth::$auth ['sk_client'], 'numbrmat' => $numbrmat));			
				if ($groupes) {
					/*foreach ($groupes as $k => $groupe) {
						$groupe['produits'] = $this->bonrec_poste->query("SELECT CASE WHEN P.lb_produit = '' THEN B.co_produit ELSE P.lb_produit END as lb_produit, P.sk_produit FROM bonrec_poste B LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit and numbrmat='".$numbrmat."' WHERE lb_hierachie='" . $groupe['lb_hierachie']. "' AND P.sk_client=:sk_client order by P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						$groupes[$k]=$groupe;	
					}*/
					/*foreach ($groupes as $k => $groupe) {
						$groupe['produits'] = $this->bonrec_poste->query("SELECT CASE WHEN P.lb_produit = '' THEN cd.co_produit ELSE P.lb_produit END as lb_produit, P.sk_produit FROM bonrec_poste B LEFT JOIN produit_had P ON P.sk_produit = B.sk_produit and numbrmat='".$numbrmat."' inner join boncde_poste cd on cd.numcde=left(numbrmat,14) and cd.sk_produit=B.sk_produit WHERE lb_hierachie='" . $groupe['lb_hierachie']. "' AND P.sk_client=:sk_client order by P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						$groupes[$k]=$groupe;	
					}*/
					foreach ($groupes as $k => $groupe) 
					{
						$groupe['produits'] = $this->bonrec_poste->query("SELECT CASE WHEN P.lb_produit = '' THEN B.co_produit ELSE P.lb_produit END as lb_produit, P.sk_produit "
								. " FROM produit_had P LEFT JOIN boncde_poste B ON P.sk_produit = B.sk_produit "
								. " WHERE P.sk_client=:sk_client AND numbrmat like '". $numbrmat."%' AND lb_hierachie='" . $groupe['lb_hierachie']. "'"
								. " order by lb_classement,P.lb_produit ", array('sk_client' => auth::$auth ['sk_client']));
						$groupes[$k]=$groupe;
					}
				}
				
				$this->smarty->assign('groupes', $groupes);	
				
				$message = $this->smarty->fetch(BASE_DIR . "pages/mailbonrmat.html");
	
				$mail = new mail();
				$mail->setFrom("ExtranetHAD@bastide-medical.fr");
				$mail->addAddress($client['lb_mail_gest1']);
				$mail->addAddress($client['lb_mail_gest2']);
				$mail->Subject = "[EXTRANET HAD] - Enregistrement du bon de récupération matériel n° " . $numbrmat ;
				$mail->msgHTML($message);
				$mail->sendEmail();
				
				// UPDATE
				$this->bonrec_materiel->update('numbrmat', $numbrmat, array('datenvmail'=>date('Y-m-d'), 'hrsenvmail' => date('H:i:s')));
				
				if ($retour)	
					return true;
			}
		}
		if ($retour)
			return false;
		$this->redirect("/bonrmat");
	}
	
}
