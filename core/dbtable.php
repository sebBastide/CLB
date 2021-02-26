<?php

class dbtable {

	public $results = array();
	public $result = array();
	public $errorCode = '';
	public $errorInfo = '';
	public $fields = array();
	public $fieldstype = array();
	private $table = "";
	private $cnx;

	function __construct($table) {
		global $connsql;
		// $this->cnx = new PDO ();
		$this->cnx = $connsql;
		$this->table = $table;
		$req = $this->cnx->query("SELECT * FROM information_schema.COLUMNS where TABLE_NAME='" . $this->table . "'");
		$result = $req->fetchAll(PDO::FETCH_ASSOC);
		$this->fields=array_column($result, 'COLUMN_NAME');
		$this->fieldstype = array_combine(array_column($result, 'COLUMN_NAME'), array_column($result, 'DATA_TYPE'));
	}

	/**
	 * 
	 * @param type $fieldsvalues
	 */
	private function convert(&$fieldsvalues) {
		foreach (array_keys($fieldsvalues) as $field) {
			if (isset($this->fieldstype[$field]) && ( in_array($this->fieldstype[$field],['int','decimal','float']))) {
				$fieldsvalues[$field] = str_replace(',', '.', $fieldsvalues[$field]);
				if (empty($fieldsvalues[$field]))
					$fieldsvalues[$field] = '0';
			}
		}
	}

	/**
	 * 2
	 * 
	 * @param string $sql        	
	 * @return PDOStatement Instance de la requete pour lire avec fetch ou fetchall
	 */
	function execSQL($sql, $params = array()) {
		$req = $this->cnx->prepare($sql);
		logsql($sql);
		if (!empty($params))
			logsql(print_r($params, true));
		$req->execute($params);
		$this->errorCode = $req->errorCode();
		$this->errorInfo = $req->errorInfo();
		logsql($this->errorCode . ' - ' . $this->errorInfo [2]);
		return $req;
	}

	/**
	 * 
	 * @param type $keys
	 * @param type $values
	 * @return type
	 */
	private function where($keys, $values) {
		$params = array();
		if (isset($keys)) {
			$where = " WHERE ";
			if (is_array($keys)) {
				foreach ($keys as $k => $key) {
					if ($where != " WHERE ")
						$where .= " AND ";
					$where .= $key . " = :k_" . $key;
					$params ['k_' . $key] = $values [$k];
				}
			} else {
				$where .= $keys . " = :k_" . $keys;
				$params ['k_' . $keys] = $values;
			}
			return array(
				'where' => $where,
				'params' => $params
			);
		} else {
			echo "ERREUR PAS DE CLE FOURNIE LORS D'UN READ OU MODIFY";
			die();
		}
	}

	/**
	 * Lit un enregistrement de la table en lui fournissant la clé
	 *
	 * @param string/array $keysNames
	 *        	Nom de la clé ou tableau de nom des cles
	 * @param string/array $keysValues
	 *        	Valeur ou tableau de valeur correspondant aux cles
	 * @return Tableau contenant l'enregistrement lu ou rien si pas trouvé
	 */
	function find($keysNames, $keysValues) {
		$wheres = $this->where($keysNames, $keysValues);
		$sql = "SELECT * FROM " . $this->table . $wheres ['where'];
		$req = $this->execSQL($sql, $wheres ['params']);
		return $req->fetch(PDO::FETCH_ASSOC);
	}

	function findOrEmpty($keysNames, $keysValues) {
		$wheres = $this->where($keysNames, $keysValues);
		$sql = "SELECT * FROM " . $this->table . $wheres ['where'];
		$req = $this->execSQL($sql, $wheres ['params']);
		if ($req === false)
			$req = $this->emptyRecord();
		return $req->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * Lit un enregistrement de la table en lui fournissant la clé
	 *
	 * @param string/array $keysNames
	 *        	Nom de la clé ou tableau de nom des cles
	 * @param string/array $keysValues
	 *        	Valeur ou tableau de valeur correspondant aux cles
	 * @return Tableau contenant l'enregistrement lu ou rien si pas trouvé
	 */
	function readkey($keysNames, $keysValues) {
		$wheres = $this->where($keysNames, $keysValues);
		$sql = "SELECT * FROM " . $this->table . $wheres ['where'];
		$req = $this->execSQL($sql, $wheres ['params']);
		return $req->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * Met un enregistrement de la table en lui fournissant la clé
	 *
	 * @param string/array $keysNames
	 *        	Nom de la clé ou tableau de nom des cles
	 * @param string/array $keysValues
	 *        	Valeur ou tableau de valeur correspondant aux cles
	 * @param array $fieldsValues
	 *        	Tableau associatif des valeurs à mettre à jour
	 * @return true si mis a jour réussie
	 */
	function update($keysNames, $keysValues, $fieldsValues) {
		$sets = " SET ";
		$this->convert($fieldsValues);
		$params = array();
		foreach (array_keys($fieldsValues) as $field) {
			if (in_array($field, $this->fields)) {
				if ($sets != " SET ")
					$sets .= " , ";
				$sets .= $field . " = :" . $field;
				$params [$field] = $fieldsValues [$field];
			}
		}
		$coduti=isset($_SESSION ['coduti']) ? $_SESSION ['coduti']:'';
		if (!in_array('moduti', array_keys($fieldsValues)))
			$sets .= " , moduti='" . $coduti . "'";
		if (!in_array('moddat', array_keys($fieldsValues)))
			$sets .= " , moddat='" . date('Y-m-d') . "'";
		if (!in_array('modheu', array_keys($fieldsValues)))
			$sets .= " , modheu='" . date('H:i:s') . "'";
		$wheres = $this->where($keysNames, $keysValues);
		$sql = "UPDATE " . $this->table . $sets . $wheres ['where'];
		$req = $this->execSQL($sql, array_merge($params, $wheres ['params']));
		return ($this->errorCode == "00000");
	}

	/**
	 * Insert un enregistrement dans la table
	 *
	 * @param array $fieldsValues
	 *        	Tableau associatif des valeurs à mettre à jour
	 * @return true si insertion réussie
	 */
	function insert($fieldsValues) {
		$flds = " ( ";
		$vals = " ) VALUES( ";
		$params = array();
		$this->convert($fieldsValues);
		foreach (array_keys($fieldsValues) as $field) {
			if (in_array($field, $this->fields)) {
				if ($flds != " ( ") {
					$flds .= " , ";
					$vals .= " , ";
				}
				$flds .= $field;
				$vals .= ':' . $field;
				$params [$field] = $fieldsValues [$field];
			}
		}
		if (!in_array('statut', array_keys($fieldsValues))) {
			$flds .= " , statut";
			$vals .= " , 'A'";
		}
		$coduti=isset($_SESSION ['coduti']) ? $_SESSION ['coduti']:'';
		if (!in_array('creuti', array_keys($fieldsValues))) {
			$flds .= " , creuti";
			$vals .= " , '" . $coduti . "'";
		}
		if (!in_array('credat', array_keys($fieldsValues))) {
			$flds .= " , credat";
			$vals .= " , '" . date('Y-m-d') . "'";
		}
		if (!in_array('creheu', array_keys($fieldsValues))) {
			$flds .= " , creheu";
			$vals .= " , '" . date('H:i:s') . "'";
		}

		$sql = "INSERT INTO " . $this->table . $flds . $vals . " )";
		$req = $this->execSQL($sql, $params);
		return ($this->errorCode == "00000");
	}

	/**
	 * Supprime un enregistrement de la table en lui fournissant la clé
	 *
	 * @param string/array $keysNames
	 *        	Nom de la clé ou tableau de nom des cles
	 * @param string/array $keysValues
	 *        	Valeur ou tableau de valeur correspondant aux cles
	 * @return true si suppression réussie
	 */
	function delete($keysNames, $keysValues) {
		$wheres = $this->where($keysNames, $keysValues);
		$sql = "DELETE FROM " . $this->table . $wheres ['where'];
		$req = $this->execSQL($sql, $wheres ['params']);
		return ($this->errorCode == "00000");
	}

	/**
	 * Execute une requete SQL et un Fetch all
	 *
	 * @param string $sql
	 *        	texte de la requete
	 * @param array $params
	 *        	Tableau des parametres de la requete
	 * @param int $typeretour
	 *        	PDO::FETCH_ASSOC par defaut
	 * @return multitype: tableau des resultat
	 */
	function query($sql, $params = array(), $typeretour = PDO::FETCH_ASSOC) {
		if (is_numeric($params)) {
			$typeretour = $params;
			$params = array();
		}
		$req = $this->execSQL($sql, $params);
		return $req->fetchAll($typeretour);
	}

	/**
	 * Execute une requete SQL et un Fetch seulement
	 *
	 * @param string $sql
	 *        	texte de la requete
	 * @param array $params
	 *        	Tableau des parametres de la requete
	 * @param int $typeretour
	 *        	PDO::FETCH_ASSOC par defaut
	 * @return multitype: tableau des resultat
	 */
	function queryFirst($sql, $params = array(), $typeretour = PDO::FETCH_ASSOC) {
		if (is_numeric($params)) {
			$typeretour = $params;
			$params = array();
		}
		$req = $this->execSQL($sql, $params);
		return $req->fetch($typeretour);
	}

	/**
	 * Recupere un tableau pour les listes combo
	 * 
	 * @param string $table Nom du fichier
	 * @param string $select champs a recuperer separee par ,
	 * @param type $order zone de tri par defaut (1 er zone)
	 * @param string $conditions condition de selection)
	 * @return array tableau liste
	 */
	function listeactifs($table, $select = '*', $order = '1', $conditions = '') {

		$sql = "SELECT $select FROM $table WHERE statut='A'";
		if (!empty($conditions))
			$sql.=' AND ' . $conditions;
		$sql.=" ORDER BY $order";
		$req = $this->execSQL($sql);
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Recupere le contenu d'une zone dans la table de la classe
	 * 
	 * @param string $cle nom de la cle recherche
	 * @param string $valcle valeur de la cle 
	 * @param string $zonlib zone libelle de retour 
	 * @return string retourne le libellé
	 */
	function recup($cle, $valcle, $zonlib, $condition = '') {
		return $this->recuplib($this->table, $cle, $valcle, $zonlib, $condition);
	}

	/**
	 * Recupere le contenu d'une zone dans une table quelconque
	 * 
	 * @param string $table nom de la table concerné
	 * @param string $cle nom de la cle recherche
	 * @param string $valcle valeur de la cle 
	 * @param string $zonlib zone libelle de retour 
	 * @return string retourne le libellé
	 */
	function recuplib($table, $cle, $valcle, $zonlib, $condition = '') {


		$sql = 'SELECT ' . $zonlib . ' FROM ' . $table . ' WHERE ' . $cle . '=:' . $cle;
		if (!empty($condition))
			$sql.=" AND " . $condition;

		$req = $this->execSQL($sql, array($cle => $valcle));
		$val = $req->fetch(PDO::FETCH_NUM);
		return $val[0];
	}

	/**
	 * Retourne un tableau associatif vide avec tous les champs de la table
	 *
	 * @return multitype: tableau des champs vide
	 */
	function emptyRecord() {
		$element = array();
		foreach ($this->fields as $field) {
			$element [$field] = '';
		}
		return $element;
	}

	/**
	 * Recupere un nouvel increment sur la cle
	 *
	 * @param string $key
	 *        	Nom de la clé
	 * @param string $length
	 *        	longueur du champ
	 * @return la valeur de la clé
	 */
	function newIncrement($key, $length) {
		$sql = "SELECT TOP 1 " . $key . " AS last FROM " . $this->table . " ORDER BY " . $key . " DESC";
		$req = $this->cnx->prepare($sql);
		$req->execute();
		$last = $req->fetch(PDO::FETCH_ASSOC);
		$this->errorCode = $req->errorCode();
		$this->errorInfo = $req->errorInfo();
		return sprintf("%1$0" . $length . "d", intval($last ['last']) + 1);
	}

}
