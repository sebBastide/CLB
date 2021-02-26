<?php

class utilisateursCtrl extends Controller {

	public $smarty;
	public $utilisateurs;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->utilisateurs = new dbtable('UTILISATEURS');
		$this->client_had = new dbtable('client_had');
	}

	public function defaut() {
		
		if (auth::$auth['grputi'] == 'U') {
			$this->redirect('utilisateurs/modifier/' . auth::$auth['coduti']);
		} else {
			$this->liste();
		}
	}

	/**
	 * Affiche la page avec smarty ( Fusion et affichage)
	 *
	 * @param string $page_a_afficher        	
	 */
	private function affiche($page_a_afficher) {
		if (empty(auth::$auth['sk_client'])) {
			$client['lb_donneur_ordre']='<<<<<< Mode administrateur >>>>>>';
		}else{
			$client = $this->client_had->find('sk_client', auth::$auth['sk_client']);
		}
		$this->smarty->assign('client', $client);
		
		if ($page_a_afficher == "form") {
			$this->smarty->displayLayout('utilisateurs/fiche.tpl', 'Fiche utilisateur');
		} elseif ($page_a_afficher == "list") {
			$this->smarty->displayLayout('utilisateurs/liste.tpl', 'Liste des utilisateurs');
		} else {
			echo 'error';
		}
	}

	/**
	 * Fontion AJAX de recup du contenu de datatable
	 */
	public function tableau_json() {
		$r_utilisateurs = $_SESSION ['r_utilisateurs'];
		
		// CONSTRUCTION DU WHERE
		$wheres = array();
		if (isset($r_utilisateurs ['r_statut']) && $r_utilisateurs ['r_statut'] != 'T')
			$wheres [] = "statut='" . $r_utilisateurs ['r_statut'] . "'";
		if (isset($r_utilisateurs ['r_nom']) && !empty($r_utilisateurs ['r_nom']))
			$wheres [] = " nom LIKE '%" . addslashes($r_utilisateurs ['r_nom']) . "%'";
		if (isset($r_utilisateurs ['r_coduti']) && !empty($r_utilisateurs ['r_coduti']))
			$wheres [] = " coduti LIKE '" . addslashes($r_utilisateurs ['r_coduti']) . "%'";
		
		// Restriction aux utilisateurs
		if (auth::$auth ['grputi']!="A") {
			$wheres [] = "sk_client  = '" . auth::$auth ['sk_client'] . "'";
			}
		
		// RECUP. DU NOMBRE TOTAL D'ENREG.
		$sqlcount = "SELECT COUNT(*) AS CPT FROM UTILISATEURS ";
		$count = $this->utilisateurs->queryFirst($sqlcount);
		
		// RECUP. DU NOMBRE D'ENREG. FILTRES.
		if (!empty($wheres))
			$countfilter = $this->utilisateurs->queryFirst($sqlcount . " WHERE " . implode(" AND ", $wheres));
		else
			$countfilter = $count;
		
		// CONSTRUCTION DE LA REQUETE.
		$fields = $this->datatable_columns($_GET);
		
		$sql = "SELECT " . implode(" , ", $fields) . " FROM UTILISATEURS ";
		if (!empty($wheres))
			$sql .= " WHERE " . implode(" AND ", $wheres);
		$sql .= $this->datatable_order_offset($_GET, $fields);
		
		// EXECUTION DE LA REQUETE.
		$elements = $this->utilisateurs->query($sql, PDO::FETCH_NUM);
		
		// MISE EN FORME DES DONNEES ET AJOUT DES OPTIONS.
		$indcode = array_search('coduti', $fields);
		$indstatut = array_search('statut', $fields);
		
		foreach ($elements as $k => $element) {
			
			$element[] = '<a href="/utilisateurs/modifier/' . $element[$indcode] . '"><img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier"></a>';
			
			if ($element[$indstatut] == 'A')
				$element[] = '<a href="#" onclick="desactiver(\'' . $element[$indcode] . '\');"><img src="/img/pictos/del.png"   alt="Désactiver" title="Désactiver"/></a>';
			else
				$element[] = '<a href="#" onclick="activer(\'' . $element[$indcode] . '\');"><img src="/img/pictos/react.png" alt="Activer"    title="Activer"   /></a>';
			$elements[$k] = $element;
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
	 * Affichage table des utilisateurs
	 * **********************************************
	 */
	public function liste() {

// valeur par defaut des recherches
		$r_utilisateurs = array(
			'r_statut' => 'A',
			'r_nom' => '',
			'r_coduti' => ''
		);
		if (isset($_SESSION ['r_utilisateurs']))
			$r_utilisateurs = array_copie($r_utilisateurs, $_SESSION ['r_utilisateurs']);
		if (isset($_POST))
			$r_utilisateurs = array_copie($r_utilisateurs, $_POST);
		
		// sauvegarde en session de la recherche
		$_SESSION ['r_utilisateurs'] = $r_utilisateurs;

		// initialisation des variables ecrans....
		$this->smarty->assign('r_utilisateurs', $r_utilisateurs);
		$this->affiche('list');
	}

	public function desactiver($coduti) {
		if (isset($coduti)) {
			$this->utilisateurs->update('coduti', $coduti, array(
				'statut' => 'D'
			));
		}
	}

	public function activer($coduti) {
		if (isset($coduti)) {
			$this->utilisateurs->update('coduti', $coduti, array(
				'statut' => 'A'
			));
		}
	}

	/**
	 * ********************************************
	 * Affichage enregistrement à modifier
	 * *********************************************
	 */
	public function modifier($coduti) {
		if (isset($coduti)) {
// Lecture enregistrement
			$element = $this->utilisateurs->find('coduti', $coduti);
// si pas trouve alors on revient sur la liste
			if ($element) {
				$this->zones_page($element);
				$this->affiche('form');
			} else {
				$this->liste();
			}
		}
	}

	public function zones_page(&$element) {
		$element['hide_coduti'] = $element['coduti'];
		
		
		$element['rech_client_had'] = "";
		if (isset($element['sk_client'])) {
			$client_had = $this->client_had->find('sk_client', $element['sk_client']);
			if (!$client_had)
				$client_had = $this->client_had->emptyRecord();
		}else {
			$client_had = $this->client_had->emptyRecord();
		}
		$this->smarty->assign('client_had', $client_had);
		
		$this->smarty->assign('element', $element);
	}

	/**
	 * *********************************************
	 * Affichage enregistrement vide pour ajout
	 * *********************************************
	 */
	public function ajouter() {
		$element = $this->utilisateurs->emptyRecord();
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
			$hide_coduti = $_POST ['hide_coduti'];
			$coduti = $_POST ['coduti'];

// Controle de la saisie
// TEST Doublon...
			$element = $this->utilisateurs->queryFirst("SELECT count(*) as w_cpt FROM UTILISATEURS WHERE coduti='" . $_POST ['coduti'] . "' and coduti<>'" . $hide_coduti . "' AND sk_client='" . auth::$auth ['sk_client']."'");
// si Doublon...
			if ($element ['w_cpt'] != 0) {
				$this->message('Ce code d\'accès est déjà utilisé', 'error');
				$this->zones_page($_POST);
				$this->smarty->assign('element', $_POST);
				$this->affiche("form");
				return;
			}
// test identifiant
			if (empty($_POST ['coduti'])) {
				$this->message('Vous devez entrer un identifiant', 'error');
				$this->zones_page($_POST);
				$this->smarty->assign('element', $_POST);
				$this->affiche("form");
				return;
			}
// test nom prenom
			if (empty($_POST ['nom']) || empty($_POST ['prenom'])) {
				$this->message('Vous devez entrer un nom et un prénom', 'error');
				$this->zones_page($_POST);
				$this->smarty->assign('element', $_POST);
				$this->affiche("form");
				return;
			}
// test mot de passe identique
			if (!empty($_POST ['mdp1']) && $_POST ['mdp1'] != $_POST ['mdp2']) {
				$this->message('Les mots de passe ne sont pas identiques', 'error');
				$this->zones_page($_POST);
				$this->smarty->assign('element', $_POST);
				$this->affiche("form");
				return;
			}
// test adresse mail
			if (!filter_var($_POST ['mail'], FILTER_VALIDATE_EMAIL)) {
				$this->message('Votre adresse mail n\'est pas valide', 'error');
				$this->zones_page($_POST);
				$this->smarty->assign('element', $_POST);
				$this->affiche("form");
				return;
			}

			if (!empty($_POST ['mdp1'])){
				$_POST ['mdp'] = $_POST ['mdp1'];
				$_POST['mdp']=md5($_POST['mdp']);
			}
// saisie valide -> mise à jour base
			if (empty($hide_coduti)) {
// INSERT
				$this->utilisateurs->insert($_POST);
				$this->message("Le code d'accès a été ajouté avec succés", "normal");
			} else {
// UPDATE
				$this->utilisateurs->update('coduti', $coduti, $_POST);
				$this->message("Le code d'accès a été modifié avec succés", "normal");
			}
		}

		unset($_POST);
		
		if (auth::$auth['grputi'] == 'U') {
			$this->redirect('accueil/defaut');
		}else{
			$this->liste();
		}
	}

	function rech_client_had() {
		$search = sql_escape("%{$_GET['term']}%");
		$search1 = sql_escape("{$_GET['term']}%");
		$data = $this->client_had->query(
				"SELECT concat(lb_donneur_ordre,' ( ',lb_adresse, ' - ', lb_cd_postal, ' ', lb_ville , ' ) ' ) as label , "
				. "lb_donneur_ordre as value, sk_client, lb_donneur_ordre, lb_adresse, lb_ville, lb_cd_postal, lb_telephone from client_had "
				. "where (sk_client like :rech1 or lb_donneur_ordre like :rech2 ) order by lb_donneur_ordre LIMIT 100", array('rech1' => $search, 'rech2' => $search));
		echo json_encode($data);
	}
}
