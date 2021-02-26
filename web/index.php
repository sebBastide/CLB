<?php
session_start();
require_once str_replace('web','config', __DIR__ ). "/config.php";
require_once BASE_DIR . "core/includes.php";
ini_set('error_log', BASE_DIR . 'logerrors.txt');
ini_set('display_errors', DEBUG);
 
spl_autoload_register('__autoload');
setlocale(LC_NUMERIC, null);
//stockage page precedente et en cours
if ($_SERVER['REQUEST_METHOD'] <> 'POST' && (!array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) || strtolower($_SERVER ['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')) {
	$_SESSION['page_prec'] = isset($_SESSION['page_en_cours']) ? $_SESSION['page_en_cours'] : '/accueil';
	$_SESSION['page_en_cours'] = $_SERVER['REQUEST_URI'];
}
// LECTURE DE L'URL DEMANDEE
if (isset($_GET ['route']) && !empty($_GET ['route']))
	$url = $_GET ['route'];
else {
	if (!isset($_SESSION ['coduti']))
		$url = 'login';
	else
		$url = 'accueil';
}
$pages = explode("/", trim($url, "/"));

// Nom de la page PHP (controlleur)
$page = strtolower($pages [0]);
$pagefilename = BASE_DIR . 'controllers/' . $page . '.php';

// test existence page
if (!file_exists($pagefilename)) {
	echo "<h1>Erreur 404 - Page introuvable</h1>";
	echo "<h2>La page $url n'existe pas sur ce serveur.</h2>";
	header('HTTP/1.0 404 Not Found');
	exit();
}

// action par defaut
if (!isset($pages [1]))
	$pages [1] = "defaut";

// action
$action = strtolower($pages [1]);

// parametres
$params = isset($pages [2]) ? array_slice($pages, 2) : array();

// test si fenetre login alors pas d'authentification necessaire
if ($page == 'login') {
	$ctrl = new loginCtrl ();
	call_user_func_array(array(
		$ctrl,
		$action
			), $params);
	// $ctrl->$action ( $params [0], $params [1], $params [2], $params [3], $params [4], $params [5], $params [6], $params [7], $params [8], $params [9], $params [10] );
	return;
}
// test si utilisateur logué et appel login si pas ok
if (!isset($_SESSION ['coduti'])) {
	$ctrl = new loginCtrl ();
	$ctrl->message('Vous devez d\'abord vous authentifier... ', 'error');
	$ctrl->defaut();
	return;
}

// CHARGEMENT AUTHENTIFICATION
if (!auth::charger($_SESSION ['coduti'])) {
	$ctrl = new loginCtrl ();
	$ctrl->message('Une erreur d\'authentification est survenue... ', 'error');
	$ctrl->defaut();
	return;
}

// TEST AUTORISATION
if (!auth::verifier($page)) {
	$ctrl = new loginCtrl ();
	$ctrl->message('Vous n\'etes pas autoriser à accéder à cette page... ', 'error');
	$ctrl->defaut();
	return;
}

// TEST EXPIRATION SESSION SI PAS AJAX
if (!array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) || strtolower($_SERVER ['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	if (isset($_SESSION ['DERNIERE_ACTION']) && (time() - $_SESSION ['DERNIERE_ACTION'] > 3600)) {
		session_unset();   // supprime les variables de session
		try {session_destroy();} catch (Exception $ex) {} // et supprime la session
		session_start();   // redemarre une session
		$ctrl = new loginCtrl ();
		$ctrl->message('Votre session a expirée...', 'error');
		$ctrl->defaut();
		return;
	}
}
$_SESSION ['DERNIERE_ACTION'] = time(); // met à jour la derniere activite
// CHARGEMENT DU CONTROLEUR
$ctrlname = $page . 'Ctrl';
$ctrl = new $ctrlname ();
// test existence action
if (!method_exists($ctrl, $action)) {
	echo "<h1>Erreur 404 - Page introuvable</h1>";
	echo "<h2>La page $url n'existe pas sur ce serveur.</h2>";
	header('HTTP/1.0 404 Not Found');
	exit();
}

// appel methode
call_user_func_array(array(
	$ctrl,
	$action
		), $params);
// $ctrl->$action ( $params [0], $params [1], $params [2], $params [3], $params [4], $params [5], $params [6], $params [7], $params [8], $params [9], $params [10] );
