<?php

class accueilCtrl extends Controller {
public $smarty;
	public $utilisateurs;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->utilisateurs = new dbtable('UTILISATEURS');
		$this->client_had = new dbtable('client_had');
		$this->boncdes_entete = new dbtable('boncde_entete');
		$this->bonrecs_dechet = new dbtable('bonrec_dechet');
		$this->bonrecs_materiel = new dbtable('bonrec_materiel');
	}

	function defaut() {
		if (empty(auth::$auth['sk_client'])) {
			$element['lb_donneur_ordre']='<<<<<< Mode administrateur >>>>>>';
			$boncdes_entete = array(array('numcde' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datliv' => ''));
			$bonrecs_dechet = array(array('numbrdec' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datrec' => ''));
			$bonrecs_materiel = array(array('numbrmat' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datrec' => ''));
			$datlim = date( "Y-m-d", time() + 2 * 24 * 60 * 60); 
		}else{
			$element = $this->client_had->find('sk_client', auth::$auth['sk_client']);
		}
		//=====================================================
		// Dernières commandes
		//=====================================================		
		$boncdes_entete = array(array('numcde' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datliv' => ''));
	
		if (auth::$auth['grputi'] == 'U' ) {
			// Lecture enregistrement
			$boncdes_entete = $this->boncdes_entete->query("SELECT numcde, datdem, lb_titre,CASE WHEN sk_patient IS NULL THEN concat(lb_nom,' ',lb_nom2) else lb_nom end as lb_nom , datliv,P.ext_patient as numpat  FROM boncde_entete B LEFT JOIN patient_had P ON numpat=P.ext_patient WHERE B.statut='A' AND B.sk_client='" . auth::$auth['sk_client'] . "' ORDER BY numcde DESC, datdem DESC LIMIT 100");
			
			if ($boncdes_entete) {	
			} else {
				$boncdes_entete = array(array('numcde' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datliv' => '','numpat' => ''));
			}
		}
		//=====================================================
		// Dernières bons recup. dechets
		//=====================================================		
		$bonrecs_dechet = array(array('numbrdec' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datrec' => ''));
		
		if (auth::$auth['grputi'] == 'U' ) {
			// Lecture enregistrement
			$bonrecs_dechet = $this->bonrecs_dechet->query("SELECT numbrdec, datdem, lb_titre, lb_nom, datrec FROM bonrec_dechet B LEFT JOIN patient_had P ON numpat=P.ext_patient WHERE B.statut='A' AND B.sk_client='" . auth::$auth['sk_client'] . "' ORDER BY numbrdec DESC, datdem DESC LIMIT 100");
			if ($bonrecs_dechet) {	
			} else {
				$bonrecs_dechet = array(array('numbrdec' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datrec' => ''));
			}
		}
		
		//=====================================================
		// Dernières bons recup. materiels
		//=====================================================		
		$bonrecs_materiel = array(array('numbrmat' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datrec' => ''));
		
		if (auth::$auth['grputi'] == 'U' ) {
			// Lecture enregistrement
			$bonrecs_materiel = $this->bonrecs_materiel->query("SELECT numbrmat, datdem, lb_titre, lb_nom, datrec FROM bonrec_materiel B LEFT JOIN patient_had P ON numpat=P.ext_patient WHERE B.statut='A' AND B.sk_client='" . auth::$auth['sk_client'] . "' ORDER BY numbrmat DESC, datdem DESC LIMIT 100");
			if ($bonrecs_materiel) {	
			} else {
				$bonrecs_materiel = array(array('numbrmat' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datrec' => ''));
			}
		}
		
		//=====================================================
		// livraison/recup J+2
		//=====================================================	
		$bons = array(array('numbon' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datint' => ''));
		
		if (auth::$auth['grputi'] == 'U' ) {
			// Lecture enregistrement
			$datlim = date( "Y-m-d", time() + 2 * 24 * 60 * 60); 
			
			$req = "(SELECT numcde as numbon, datdem, lb_titre, lb_nom, datliv as datint FROM boncde_entete B LEFT JOIN patient_had P ON numpat=P.ext_patient WHERE B.statut='A' AND B.sk_client='" . auth::$auth['sk_client'] . "' AND datliv>='".$datlim."') UNION (SELECT numbrdec as numbon, datdem, lb_titre, lb_nom, datrec as datint FROM bonrec_dechet B LEFT JOIN patient_had P ON numpat=P.ext_patient WHERE B.statut='A' AND B.sk_client='" . auth::$auth['sk_client'] . "' AND datrec>='".$datlim."') UNION (SELECT numbrmat as numbon, datdem, lb_titre, lb_nom, datrec as datint FROM bonrec_materiel B LEFT JOIN patient_had P ON numpat=P.ext_patient WHERE B.statut='A' AND B.sk_client='" . auth::$auth['sk_client'] . "' AND datrec>='".$datlim."') ORDER BY numbon DESC, datint DESC LIMIT 100";
			$bons = $this->bonrecs_dechet->query($req);
			if ($bons) {	
			} else {
				$bons = array(array('numbon' => '', 'datdem' => '', 'lb_titre' => '', 'lb_nom' => '','datint' => ''));
			}
		}
		
		//=====================================================
		// Nb bons de boncde_entete  
		// Nb bons de bonrec_dechet
		// Nb bons de bonrec_materiel
		//=====================================================		
		$datdeb = date('Y').'0101';
			
		$nb = $this->boncdes_entete->queryFirst("SELECT count(*) as nb FROM boncde_entete WHERE statut='A' AND sk_client='" . auth::$auth['sk_client'] . "' AND datdem >= '".$datdeb."'");
		$this->smarty->assign('nbcde', $nb);
			
		$nb = $this->bonrecs_dechet->queryFirst("SELECT count(*) as nb FROM bonrec_dechet WHERE statut='A' AND sk_client='" . auth::$auth['sk_client'] . "' AND datdem >= '".$datdeb."'");
		$this->smarty->assign('nbdec', $nb);
			
		$nb = $this->bonrecs_materiel->queryFirst("SELECT count(*) as nb FROM bonrec_materiel WHERE statut='A' AND sk_client='" . auth::$auth['sk_client'] . "' AND datdem >= '".$datdeb."'");
		$this->smarty->assign('nbmat', $nb);
		
		
		$this->smarty->assign('boncdes_entete', $boncdes_entete);
		$this->smarty->assign('bonrecs_dechet', $bonrecs_dechet);
		$this->smarty->assign('bonrecs_materiel', $bonrecs_materiel);
		$this->smarty->assign('bons', $bons);
		$this->smarty->assign('datlim', $datlim);
		
		$this->smarty->assign('element', $element);
		$this->smarty->displayLayout('accueil/defaut.tpl', "ACCUEIL");
		
		$r_boncde = array(
			'r_numbon' => '',
			'r_datdem' => '',
			'r_datint' => '',
			'r_typcde' => 'B'			
		);
		
	}
	
	public function recherche(){

		//==============================================
		//recherche patient
		//==============================================
		if (isset($_POST['btn_recherche_patient'])){
			
			if (empty($_POST['r_numero'])) {
				$_POST['r_numero']='*';
			}
			if (empty($_POST['r_nom'])) {
				$_POST['r_nom']='*';
			}
			if (empty($_POST['r_datenaissance'])) {
				$_POST['r_datenaissance']='*';
			}else{
				$_POST['r_datenaissance'] = str_replace("/","-",$_POST['r_datenaissance']);
			}
			$this->redirect('/patients/liste/'.$_POST['r_numero'].'/'.$_POST['r_nom'].'/'.$_POST['r_datenaissance']);
		}
		//==============================================
		//recherche bon de cde, récup mat, recup dechet
		//==============================================
		if (isset($_POST['btn_recherche_cde'])){
			
			if (empty($_POST['r_typcde'])) {
				$_POST['r_typcde']='*';
			}
			
			if (empty($_POST['r_numbon'])) {
				$_POST['r_numbon']='*';
			}

			if (empty($_POST['r_datdem'])) {
				$_POST['r_datdem']='*';
			}else{
				$_POST['r_datdem'] = str_replace("/","-",$_POST['r_datdem']);
			}

			if (empty($_POST['r_datint'])) {
				$_POST['r_datint']='*';
			}else{
				$_POST['r_datint'] = str_replace("/","-",$_POST['r_datint']);
			}
		
			if ($_POST['r_typcde'] == "C"){
				$this->redirect('/boncdes/liste/'.$_POST['r_numbon'].'/'.$_POST['r_datdem'].'/'.$_POST['r_datint']);
			}
			if ($_POST['r_typcde'] == "D"){
				$this->redirect('/bonrdec/liste/'.$_POST['r_numbon'].'/'.$_POST['r_datdem'].'/'.$_POST['r_datint']);
			}
			if ($_POST['r_typcde'] == "M"){
				$this->redirect('/bonrmat/liste/'.$_POST['r_numbon'].'/'.$_POST['r_datdem'].'/'.$_POST['r_datint']);
			}
				
		}
	}
}
