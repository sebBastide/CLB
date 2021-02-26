<?php

class auth {

	public static $authok = false;
	public static $coduti = "";
	public static $auth = array();

	/**
	 * Chargement du code utilisateur
	 * @param string $coduti
	 */
	public static function charger($coduti) {
		self::$coduti = $coduti;
		$_SESSION ['coduti'] = $coduti;
		if (isset($_SESSION ['auth']['coduti']) && $_SESSION ['auth']['coduti'] = $coduti) {
			self::$auth = $_SESSION ['auth'];
		} else {
			$util = new dbtable('UTILISATEURS');
			self::$auth = $util->find('coduti', $coduti);
			$_SESSION ['auth'] = self::$auth;
			// log connexions
			$hiscons = new dbtable('HISCON');
			$browser=  getBrowser();
			$hiscons->insert(array(
			'coduti' => $coduti, 
			'datcon' => date('Y-m-d'), 
			'heucon' => date('H:i:s'), 
			'adrip' => $_SERVER["REMOTE_ADDR"], 
			'navig' => $browser['name'], 
			'vernag' => $browser['version'], 
			'os' => $browser['platform'], 
			'useragent' => mb_substr($_SERVER["HTTP_USER_AGENT"], 0, 255)
			));
		}
		if (isset(self::$auth['coduti']))
			self::$authok = true;

		return self::$authok;
	}

	/**
	 * Verifie si la page demandée est autorisée
	 * 
	 * @param string $page        	
	 * @return boolean true si autorisé sinon false
	 */
	public static function verifier($page) {
			return true;
	}

}
