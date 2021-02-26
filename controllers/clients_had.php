<?php

class clients_hadCtrl extends Controller {

	public $smarty;
	public $client_had;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->client_had = new dbtable('client_had');
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
			$this->smarty->displayLayout('clients_had/fiche.tpl', 'Gérer client HAD');
		} elseif ($page_a_afficher == "list") {
			$this->smarty->displayLayout('clients_had/liste.tpl', 'Liste des clients HAD');
		} else {
			echo 'error';
		}
	}

	/**
	 * Fontion AJAX de recup du contenu de datatable
	 */
	public function tableau_json() {
		
		$r_clients_had = $_SESSION ['r_clients_had'];
		
		// CONSTRUCTION DU WHERE
		$wheres = array();

		if (isset($r_clients_had ['r_statut']) && $r_clients_had  ['r_statut'] != 'T')
			$wheres[] = "statut='" . $r_clients_had  ['r_statut'] . "'";

		if (isset($r_clients_had ['r_sk_client']) && !empty($r_clients_had ['r_sk_client']))
			$wheres [] = " sk_client LIKE '%" . sql_escape($r_clients_had ['r_sk_client']) . "%'";
		
		if (isset($r_clients_had ['r_lb_donneur_ordre']) && !empty($r_clients_had ['r_lb_donneur_ordre']))
			$wheres [] = " lb_donneur_ordre LIKE '%" . sql_escape($r_clients_had ['r_lb_donneur_ordre']) . "%'";
		
		// Restriction aux utilisateurs
		if (auth::$auth ['grputi']!="A") {
		$wheres [] = "sk_client = '" . auth::$auth ['sk_client'] . "'";
	}
	
		// RECUP. DU NOMBRE TOTAL D'ENREG.
		$sqlcount = "SELECT COUNT(*) AS CPT FROM client_had ";
		$count = $this->client_had->queryFirst($sqlcount);
		
		// RECUP. DU NOMBRE D'ENREG. FILTRES.
		if (!empty($wheres))
			$countfilter = $this->client_had->queryFirst($sqlcount . " WHERE " . implode(" AND ", $wheres));
		else
			$countfilter = $count;
		
		// CONSTRUCTION DE LA REQUETE.
		$fields = $this->datatable_columns($_GET);
		$sql = "SELECT " . implode(" , ", $fields) . " FROM client_had ";
		
		if (!empty($wheres))
			$sql .= " WHERE " . implode(" AND ", $wheres);
		$sql .= $this->datatable_order_offset($_GET, $fields);
	
		// EXECUTION DE LA REQUETE.
		$elements = $this->client_had->query($sql, PDO::FETCH_NUM);
		
		// MISE EN FORME DES DONNEES ET AJOUT DES OPTIONS.
		$indcode = array_search('sk_client', $fields);
		$indstatut = array_search('statut', $fields);
		
		foreach ($elements as $k => $element) {
			
			$element[] = '<a href="/clients_had/modifier/' . $element[$indcode] . '"><img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier"></a>';
			
			if ($element[$indstatut] == 'A')
				$element[] = '<a href="#" onclick="desactiver(\'' . $element[$indcode] . '\');"><img src="/img/pictos/del.png"   alt="Désactiver" title="Supprimer"/></a>';
			else
				$element[] = '<a href="#" onclick="activer(\'' . $element[$indcode] . '\');"><img src="/img/pictos/react.png" alt="Activer"    title="Réactiver"   /></a>';
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
	 * Affichage table des clients_had
	 * **********************************************
	 */
	public function liste() {
		
		// valeur par defaut des recherches
		$r_clients_had = array(
			'r_sk_client' => '',
			'r_lb_donneur_ordre' => '',
			'r_statut' => ''		
		);
		
		if (isset($_SESSION ['r_clients_had']))
			$r_clients_had = array_copie($r_clients_had, $_SESSION ['r_clients_had']);

		if (isset($_POST))
			$r_clients_had = array_copie($r_clients_had, $_POST);

		// sauvegarde en session de la recherche
		$_SESSION ['r_clients_had'] = $r_clients_had;

		// initialisation des variables ecrans....
		$this->smarty->assign('r_clients_had', $r_clients_had);
		$this->affiche('list');
	}
	
	
	public function desactiver($sk_client) {
		/**
		 * **********************************************
		 * Désactivation 
		 * **********************************************
		 */
		if (isset($sk_client)) {
			$this->client_had->update('sk_client', $sk_client, array(
				'statut' => 'D'
			));
			$this->liste();
		}
	}

	public function activer($sk_client) {
		/**
		 * **********************************************
		 * Activation
		 * **********************************************
		 */
		if (isset($sk_client)) {
			$this->client_had->update('sk_client', $sk_client, array(
				'statut' => 'A'
			));
			$this->liste();
		}
	}

	public function modifier($sk_client) {
		/**
		 * ********************************************
		 * Affichage enregistrement à modifier
		 * *********************************************
		 */
		if (isset($sk_client)) {
			// Lecture enregistrement
			$client = $this->client_had->readkey('sk_client', $sk_client);
			// si pas trouve alors on revient sur la liste
			if ($client) {
				$client['hide_sk_client'] = $client['sk_client'];
				$this->smarty->assign('client', $client);
				$this->affiche('form');
			} else {
				$this->liste();
			}
		}
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
		$this->smarty->assign('client', $_POST);
		$this->affiche("form");
		exit();
	}

	public function ajouter() {
		/**
		 * *********************************************
		 * Affichage enregistrement vide pour ajout
		 * *********************************************
		 */
		$client = $this->client_had->emptyRecord();
		$client['hide_sk_client'] = '';

		$this->smarty->assign('client', $client);
		$this->affiche("form");
	}

	public function enregistrer() {
		/**
		 * *********************************************
		 * Enregistrement modification
		 * *********************************************
		 */
		if (isset($_POST['btn_enregistrer'])) {
		
			$sk_client = $_POST ['sk_client'];

			//=======================
			// Controle de la saisie
			//=======================
			//=======================
			// infos générales
			//=======================
			// SK_client
			if (empty($_POST['sk_client'])) {
				$this->erreur('N° de clent HAD invalide', 0, 'sk_client');
			}
			if (empty($_POST['hide_sk_client'])) {
				$client = $this->client_had->queryFirst("SELECT count(*) as w_cpt FROM client_had WHERE sk_client=" . $_POST ['sk_client']);
		
				//si Doublon sk_client...
				if ($client ['w_cpt'] != 0) {
					$this->erreur('Ce client HAD existe déjà : saisie invalide', 0, 'sk_client');
				}
			}
			// Donneur ordre
			if (empty($_POST['lb_donneur_ordre'])) {
				$this->erreur('Nom client HAD invalide', 1, 'lb_donneur_ordre');
			}
			
			// Prefixe numérotation
			if (empty($_POST['prefixe_num'])) {
				$this->erreur('Préfixe de numérotation invalide', 1, 'prefixe_num');
			}
			
			// saisie valide -> mise à jour base
			if (empty($_POST['hide_sk_client'])) {
			
				$this->client_had->insert($_POST);
			
			} else {
				// UPDATE
				$this->client_had->update('sk_client', $sk_client, $_POST);
			}
			unset($_POST);
		}
			$this->liste();
	}
}
