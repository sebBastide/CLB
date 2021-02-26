<?php

class produits_hadCtrl extends Controller {

	public $smarty;
	public $client_had;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->client_had = new dbtable('client_had');
		$this->produit_had = new dbtable('produit_had');		
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
		
		if (empty(auth::$auth['sk_produit'])) {
			$element['lb_donneur_ordre']='<<<<<< Mode administrateur >>>>>>';
		}else{
			$element = $this->client_had->find('sk_client', auth::$auth['sk_client']);
		}
		$this->smarty->assign('element', $element);
		if ($page_a_afficher == "form") {
			$this->smarty->displayLayout('produits_had/fiche.tpl', 'Gérer produit HAD');
		} elseif ($page_a_afficher == "list") {
			$this->smarty->displayLayout('produits_had/liste.tpl', 'Liste des produits HAD');
		} else {
			echo 'error';
		}
	}

	/**
	 * Fontion AJAX de recup du contenu de datatable
	 */
	public function tableau_json() {
		
		$r_produits_had = $_SESSION ['r_produits_had'];
		
		// CONSTRUCTION DU WHERE
		$wheres = array();

		if (isset($r_produits_had ['r_statut']) && $r_produits_had  ['r_statut'] != 'T')
			$wheres[] = "statut='" . $r_produits_had  ['r_statut'] . "'";

		if (isset($r_produits_had ['r_sk_produit']) && !empty($r_produits_had ['r_sk_produit']))
			$wheres [] = " sk_produit LIKE '%" . sql_escape($r_produits_had ['r_sk_produit']) . "%'";
		
		if (isset($r_produits_had ['r_lb_produit']) && !empty($r_produits_had ['r_lb_produit']))
			$wheres [] = " lb_produit LIKE '%" . sql_escape($r_produits_had ['r_lb_produit']) . "%'";
		
		// Restriction aux utilisateurs
		if (auth::$auth ['grputi']!="A") {
		$wheres [] = "sk_client = '" . auth::$auth ['sk_client'] . "'";
	}
	
		// RECUP. DU NOMBRE TOTAL D'ENREG.
		$sqlcount = "SELECT COUNT(*) AS CPT FROM produit_had ";
		$count = $this->produit_had->queryFirst($sqlcount);
		
		// RECUP. DU NOMBRE D'ENREG. FILTRES.
		if (!empty($wheres))
			$countfilter = $this->produit_had->queryFirst($sqlcount . " WHERE " . implode(" AND ", $wheres));
		else
			$countfilter = $count;
		
		// CONSTRUCTION DE LA REQUETE.
		$fields = $this->datatable_columns($_GET);
		$sql = "SELECT " . implode(" , ", $fields) . " FROM produit_had ";
		
		if (!empty($wheres))
			$sql .= " WHERE " . implode(" AND ", $wheres);
		$sql .= $this->datatable_order_offset($_GET, $fields);
	
		// EXECUTION DE LA REQUETE.
		$elements = $this->produit_had->query($sql, PDO::FETCH_NUM);
		
		// MISE EN FORME DES DONNEES ET AJOUT DES OPTIONS.
		$indcode = array_search('sk_produit', $fields);
		$indstatut = array_search('statut', $fields);
		
		foreach ($elements as $k => $element) {
	
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
	 * Affichage table 
	 * **********************************************
	 */
	public function liste() {
		
		// valeur par defaut des recherches
		$r_produits_had = array(
			'r_sk_produit' => '',
			'r_lb_produit' => '',
			'r_statut' => ''		
		);
		
		if (isset($_SESSION ['r_produits_had']))
			$r_produits_had = array_copie($r_produits_had, $_SESSION ['r_produits_had']);

		if (isset($_POST))
			$r_produits_had = array_copie($r_produits_had, $_POST);

		// sauvegarde en session de la recherche
		$_SESSION ['r_produits_had'] = $r_produits_had;

		// initialisation des variables ecrans....
		$this->smarty->assign('r_produits_had', $r_produits_had);
		$this->affiche('list');
	}
	
	
	public function desactiver($sk_produit) {
		/**
		 * **********************************************
		 * Désactivation 
		 * **********************************************
		 */
		if (isset($sk_produit)) {
			$this->produit_had->update('sk_produit', $sk_produit, array(
				'statut' => 'D'
			));
			$this->liste();
		}
	}

	public function activer($sk_produit) {
		/**
		 * **********************************************
		 * Activation
		 * **********************************************
		 */
		if (isset($sk_produit)) {
			$this->produit_had->update('sk_produit', $sk_produit, array(
				'statut' => 'A'
			));
			$this->liste();
		}
	}

	public function modifier($sk_produit) {
		/**
		 * ********************************************
		 * Affichage enregistrement à modifier
		 * *********************************************
		 */
		if (isset($sk_produit)) {
			// Lecture enregistrement
			$produit = $this->produit_had->readkey('sk_produit', $sk_produit);
			// si pas trouve alors on revient sur la liste
			if ($produit) {
				$produit['hide_sk_produit'] = $produit['sk_produit'];
				$this->smarty->assign('produit', $produit);
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
		$this->smarty->assign('produit', $_POST);
		$this->affiche("form");
		exit();
	}
}
