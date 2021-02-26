<?php

class loginCtrl extends Controller {
	
/**
* *************************************************
* test : mail catcher http://192.168.168.11:1080/
* **************************************************
*/

	public $smarty;
	public $utilisateurs;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->utilisateurs = new dbtable('UTILISATEURS');
	}

	function defaut() {
		$this->login();	
	}

	function login() {
		/**
		 * *************************************************
		 * Fusion et affichage
		 * **************************************************
		 */
		// assignation des variables et tableaux
		$this->smarty->assign('titrepage', 'HAD');
		$this->smarty->assign('listemenu', '');
		// fusion et affichage
		$this->smarty->displayLayout('login/login.tpl', "Identification");
	}

	function logout() {
		session_unset(); // supprime les variables de session
		session_destroy(); // et supprime la session
		session_start(); // redemarre une session
		$this->redirect('login');
	}

	function verif() {
		$utilisateur = $this->utilisateurs->queryFirst ( "SELECT * FROM UTILISATEURS WHERE coduti='" . addslashes ( $_POST ["login"] ) . "' AND mdp='" . md5( $_POST ["mdp"] ) . "'" );
		
		if (! isset ( $utilisateur ['coduti'] )) {
			$this->message ( 'Identifiant ou mot de passe incorrect', 'error' );
			$this->defaut ();
		} else {
			// on stocke en session les infos de l'utilisateur
			auth::charger($_POST ["login"]);
			$this->redirect('accueil');
		}
	}
	
	function perdumdp() {
		$this->smarty->assign("element", array("login" => ""));
		$this->smarty->displayLayout("login/login_perdumdp.tpl", "Mot de passe perdu");
	}
	
	function initmdp() {
	
			
		extract($_POST, EXTR_PREFIX_ALL, 'post');
		
		$mail = $this->utilisateurs->recup("mail", $post_login, "mail");
		if (empty($mail)) {
			$this->message("Désolé, cette adresse mail n'existe pas dans notre base","error");
			$this->smarty->assign("element", $_POST);
			$this->smarty->displayLayout("login/login_perdumdp.tpl", "Mot de passe perdu");
			return;
		}
		$codrei = md5($_POST['login']) . time();
		$this->utilisateurs->update('mail', $mail, array('codrei' => $codrei));
		$utilisateur = $this->utilisateurs->find('mail', $mail);
		$mail = new mail();
		$this->smarty->assign('lien', BASE_URL . 'login/initmdp_page/' . $codrei);
		$this->smarty->assign('utilisateur', $utilisateur);
		$message = $this->smarty->fetch(BASE_DIR . "pages/mailreinitmotdepasse.html");
		$mail = new mail();
		$mail->setFrom("ExtranetHAD@bastide-medical.fr");
		$mail->addAddress($utilisateur['mail']);
		$mail->Subject = "[EXTRANET HAD] - Demande de réinitialistion de mot de passe";
		$mail->msgHTML($message);
		$mail->sendEmail();

		$this->message('Votre demande de réinitialisation de mot de passe vous a été envoyée');
		$this->smarty->displayLayout("login/login.tpl", "Identification");
	}
	
	function initmdp_page($codrei) {
		$utilisateur = $this->utilisateurs->find('codrei', $codrei);
		if (!$utilisateur){
			$this->message("Ce lien n'est plus valide..","error");
			$this->perdumdp();
			exit;
		}
		$this->smarty->assign("element", $utilisateur);
		$this->smarty->displayLayout("login/login_initmdp.tpl", "Mot de passe");
	}
	
	function initmdp_conf($codrei) {
		
		$_POST['codrei']=$codrei;
		
		extract($_POST, EXTR_PREFIX_ALL, 'post');
		
		if ($post_mdp1 != $post_mdp2) {
			$this->message("Le mot de passe de confirmation ne correspond pas au mot de passe","error");
			$this->smarty->assign('element', $_POST);
			$this->smarty->displayLayout("login/login_initmdp.tpl", "Mot de passe");
			exit;
		}
		$coduti = $this->utilisateurs->recup("codrei", $codrei, "coduti");
		if ($coduti != $post_coduti) {
			$this->message("Votre code de réinitialisation n'est plus valide","erreur");
			$this->smarty->assign('element', $_POST);
			$this->smarty->displayLayout("login/login_initmdp.tpl", "Mot de passe");
			exit;
		}
		$this->utilisateurs->update("coduti", $coduti, array("mdp"=>md5($post_mdp1),"codrei"=>""));
		auth::charger($coduti);
		$this->message("Votre mot de passe a été réinitialisé...", 'normal');
		$this->accueil();
	}
}
