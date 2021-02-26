<?php

class contactCtrl extends Controller {

public $smarty;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
	}

	function defaut() {
		debug($_SESSION);
		$this->smarty->displayLayout('templates/test.tpl', "TEST");
	}
}
