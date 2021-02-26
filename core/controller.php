<?php

class controller {

	private $cnxsql;

	function __construct() {
		global $connsql;
		$this->cnxsql = $connsql;
	}

	function message($message, $type = 'normal') {
		if (isset($_SESSION['message'] ))
			$_SESSION['message'] .= '<div class="msg ' . $type . '">' . $message . '</div>';
		else
			$_SESSION['message'] = '<div class="msg ' . $type . '">' . $message . '</div>';
	}

	function redirect($url) {
		if (strtolower(mb_substr($url, 0, 5)) != 'http:')
			$url = BASE_URL . ltrim($url, '/');
		header('location:' . $url);
	}

	function accueil() {
		$acc = new accueilCtrl();
		$acc->defaut();
	}

	function datatable_order_offset($get, $fields) {
		$v = '';
		if (isset($get['order'][0]['column'])) {
			$v.=" ORDER BY " . $fields[$get['order'][0]['column']];
			if (isset($get['order'][0]['dir']))
				$v.="  " . $get['order'][0]['dir'];
		} else
			$v.=" ORDER BY " . $fields[0];
		if (isset($get['start']) && $get['length'] != '-1') {
			if (trim($_GET['start']) == '')
				$_GET['start'] = '0';
			$v.=" LIMIT " . $get['start'] . " ," . $get['length'] ;
		}
		return $v;
	}

	function datatable_columns($get) {
		$ret = array();
		foreach ($get['columns'] as $col) {
			if (!empty($col['name']))
				$ret[] = $col['name'];
		}
		return $ret;
	}

}
