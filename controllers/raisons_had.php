<?php

class raisons_hadCtrl extends Controller {

	public $smarty;
	public $client_had;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->client_had = new dbtable('client_had');
		$this->raison_had = new dbtable('raison_had');
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
			$this->smarty->displayLayout('raisons_had/fiche.tpl', 'Gérer raisons fin HAD');
		} elseif ($page_a_afficher == "list") {
			$this->smarty->displayLayout('raisons_had/liste.tpl', 'Liste des raisons fin HAD');
		} else {
			echo 'error';
		}
	}

	/**
	 * Fontion AJAX de recup du contenu de datatable
	 */
	public function tableau_json() {
		
		$r_raisons_had = $_SESSION ['r_raisons_had'];
		
		// CONSTRUCTION DU WHERE
		$wheres = array();

		if (isset($r_raisons_had ['r_statut']) && $r_raisons_had  ['r_statut'] != 'T')
			$wheres[] = "statut='" . $r_raisons_had  ['r_statut'] . "'";

		if (isset($r_raisons_had ['r_codrai']) && !empty($r_raisons_had ['r_codrai']))
			$wheres [] = " codrai LIKE '%" . sql_escape($r_raisons_had ['r_codrai']) . "%'";
		
		if (isset($r_raisons_had ['r_librai']) && !empty($r_raisons_had ['r_librai']))
			$wheres [] = " librai LIKE '%" . sql_escape($r_raisons_had ['r_librai']) . "%'";
			
		// RECUP. DU NOMBRE TOTAL D'ENREG.
		$sqlcount = "SELECT COUNT(*) AS CPT FROM raison_had ";
		$count = $this->raison_had->queryFirst($sqlcount);
		
		// RECUP. DU NOMBRE D'ENREG. FILTRES.
		if (!empty($wheres))
			$countfilter = $this->raison_had->queryFirst($sqlcount . " WHERE " . implode(" AND ", $wheres));
		else
			$countfilter = $count;
		
		// CONSTRUCTION DE LA REQUETE.
		$fields = $this->datatable_columns($_GET);
		$sql = "SELECT " . implode(" , ", $fields) . " FROM raison_had ";
		
		if (!empty($wheres))
			$sql .= " WHERE " . implode(" AND ", $wheres);
		$sql .= $this->datatable_order_offset($_GET, $fields);
	
		// EXECUTION DE LA REQUETE.
		$elements = $this->raison_had->query($sql, PDO::FETCH_NUM);
		
		// MISE EN FORME DES DONNEES ET AJOUT DES OPTIONS.
		$indcode = array_search('codrai', $fields);
		$indstatut = array_search('statut', $fields);
		
		foreach ($elements as $k => $element) {
			
			$element[] = '<a href="/raisons_had/modifier/' . $element[$indcode] . '"><img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier"></a>';
			
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
		$r_raisons_had = array(
			'r_codrai' => '',
			'r_librai' => '',
			'r_statut' => 'A'		
		);
		
		if (isset($_SESSION ['r_raisons_had']))
			$r_raisons_had = array_copie($r_raisons_had, $_SESSION ['r_raisons_had']);

		if (isset($_POST))
			$r_raisons_had = array_copie($r_raisons_had, $_POST);

		// sauvegarde en session de la recherche
		$_SESSION ['r_raisons_had'] = $r_raisons_had;

		// initialisation des variables ecrans....
		$this->smarty->assign('r_raisons_had', $r_raisons_had);
		$this->affiche('list');
	}
	
	
	public function desactiver($codrai) {
		/**
		 * **********************************************
		 * Désactivation 
		 * **********************************************
		 */
		if (isset($codrai)) {
			$this->raison_had->update('codrai', $codrai, array(
				'statut' => 'D'
			));
			$this->liste();
		}
	}

	public function activer($codrai) {
		/**
		 * **********************************************
		 * Activation
		 * **********************************************
		 */
		if (isset($codrai)) {
			$this->raison_had->update('codrai', $codrai, array(
				'statut' => 'A'
			));
			$this->liste();
		}
	}

	public function modifier($codrai) {
		/**
		 * ********************************************
		 * Affichage enregistrement à modifier
		 * *********************************************
		 */
		if (isset($codrai)) {
			// Lecture enregistrement
			$raison = $this->raison_had->readkey('codrai', $codrai);
			// si pas trouve alors on revient sur la liste
			if ($codrai) {
				$raison['hide_codrai'] = $raison['codrai'];
				$this->smarty->assign('raison', $raison);
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
		$this->smarty->assign('raison', $_POST);
		$this->affiche("form");
		exit();
	}

	public function ajouter() {
		/**
		 * *********************************************
		 * Affichage enregistrement vide pour ajout
		 * *********************************************
		 */
		$raison = $this->raison_had->emptyRecord();
		$raison['hide_codrai'] = '';

		$this->smarty->assign('raison', $raison);
		$this->affiche("form");
	}

	public function enregistrer() {
		/**
		 * *********************************************
		 * Enregistrement modification
		 * *********************************************
		 */
		if (isset($_POST['btn_enregistrer'])) {
		
			$codrai = $_POST ['codrai'];

			//=======================
			// Controle de la saisie
			//=======================
			//=======================
			// infos générales
			//=======================
			// SK_client
			if (empty($_POST['codrai'])) {
				$this->erreur('Code invalide', 0, 'codrai');
			}
			if (empty($_POST['hide_codrai'])) {
				$raison = $this->raison_had->queryFirst("SELECT count(*) as w_cpt FROM raison_had WHERE codrai=" . $_POST ['codrai']);
		
				//si Doublon ...
				if ($raison ['w_cpt'] != 0) {
					$this->erreur('Ce code existe déjà : saisie invalide', 0, 'codrai');
				}
			}
			// Libellé
			if (empty($_POST['librai'])) {
				$this->erreur('Libellé invalide', 1, 'librai');
			}
			
			// saisie valide -> mise à jour base
			if (empty($_POST['hide_codrai'])) {
				$this->raison_had->insert($_POST);
			} else {
				// UPDATE
				$this->raison_had->update('codrai', $codrai, $_POST);
			}
			unset($_POST);
		}
			$this->liste();
	}
}
