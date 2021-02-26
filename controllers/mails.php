<?php

class mailsCtrl extends Controller {

	public $smarty;
	public $mail;

	public function __construct() {
		parent::__construct();
		$this->smarty = new SmartyID ();
		$this->mail = new dbtable('MAILS');
	}

	public function defaut() {
		$this->liste();
	}

	private function affiche($page_a_afficher) {

		/**
		 * *************************************************
		 * Fusion et affichage
		 * **************************************************
		 */
		if ($page_a_afficher == "form") {
			$this->smarty->displayLayout('mails/fiche.tpl', 'Fiche mail');
		} elseif ($page_a_afficher == "list") {
			$this->smarty->displayLayout('mails/liste.tpl', 'Liste des mails');
		} else {
			echo 'error';
		}
	}

	public function tableau_json() {
		$r_mails = $_SESSION['r_mails'];

		// CONSTRUCTION DU WHERE	
		$wheres = array("statut='A'");
		if (isset($r_mails ['r_subject']) && !empty($r_mails ['r_subject']))
			$wheres[] = " subject LIKE '%" . addslashes($r_mails ['r_subject']) . "%'";
		if (isset($r_mails ['r_mailfrom']) && !empty($r_mails ['r_mailfrom']))
			$wheres[] = " mailfrom LIKE '" . $r_mails['r_mailfrom'] . "%'";
		if (isset($r_mails ['r_mailto']) && !empty($r_mails ['r_mailto']))
			$wheres[] = " mailto LIKE '" . $r_mails['r_mailto'] . "%'";

		// RECUP. DU NOMBRE TOTAL D'ENREG.	
		$sqlcount = "SELECT COUNT(*) AS CPT FROM MAILS ";
		$count = $this->mail->queryFirst($sqlcount);

		// RECUP. DU NOMBRE D'ENREG. FILTRES	
		if (!empty($wheres))
			$countfilter = $this->mail->queryFirst($sqlcount . " WHERE " . implode(" AND ", $wheres));
		else
			$countfilter = $count;

		// CONSTRUCTION DE LA REQUETE
		//$fields=array('mailto','mailfrom','subject','intreg','statut');
		$fields = $this->datatable_columns($_GET);
		$sql = "SELECT " . implode(" , ", $fields) . " FROM MAILS ";
		$sql= str_replace('credat', "DATE_FORMAT(credat, '%d-%m-%Y') as credat",$sql);
		$sql= str_replace('creheu', "DATE_FORMAT(creheu, '%T') as creheu",$sql);
		if (!empty($wheres))
			$sql.= " WHERE " . implode(" AND ", $wheres);

		// AJOUT DU TRI ET OFFSET
		$order = $this->datatable_order_offset($_GET, $fields);
		$order = str_replace("credat  asc","credat asc ,creheu asc ",$order);
		$order = str_replace("credat  desc","credat desc ,creheu desc ",$order);
		$sql.=$order;

		// EXECUTION DE LA REQUETE
		$elements = $this->mail->query($sql, PDO::FETCH_NUM);

		// MISE EN FORME DES DONNEES ET AJOUT DES OPTIONS
		$indcode = array_search('id', $fields);
		$indsubj = array_search('subject', $fields);
		foreach ($elements as $k => $element) {
			$element[$indsubj] = '<a href="#" onclick="editer(\'' . $element[$indcode] . '\');">'.$element[$indsubj].'</a>';
			$element[] = '<a href="#" onclick="editer(\'' . $element[$indcode] . '\');"><img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier"></a>';
			$elements[$k] = $element;
		}
		// RENVOI DU RESULTAT
		$output = array(
			"draw" => $_GET['draw'],
			"recordsTotal" => $count['CPT'],
			"recordsFiltered" => $countfilter['CPT'],
			"data" => $elements
		);
		echo json_encode($output);
	}

	public function liste() {

		/**
		 * **********************************************
		 * Affichage table des mail
		 * **********************************************
		 */
		//valeur par defaut des recherches
		$r_mails = array(
			'r_subject' => '',
			'r_mailfrom' => '',
			'r_mailto' => ''
		);
		if (isset($_SESSION['r_mails']))
			$r_mails = array_copie($r_mails, $_SESSION['r_mails']);
		if (isset($_POST))
			$r_mails = array_copie($r_mails, $_POST);
		//sauvegarde en session de la recherche
		$_SESSION['r_mails'] = $r_mails;

		//initialisation des variables ecrans....
		$this->smarty->assign('r_mails', $r_mails);
		$this->affiche('list');
	}

	public function modifier($id) {
		/**
		 * ********************************************
		 * Affichage enregistrement à modifier
		 * *********************************************
		 */
		if (isset($id)) {
			// Lecture enregistrement
			$element = $this->mail->readkey('id', $id);
			// si pas trouve alors on revient sur la liste
			if ($element) {
				$element['hide_id'] = $element['id'];
				$this->smarty->assign('element', $element);
				$this->affiche('form');
			} else {
				$this->liste();
			}
		}
	}

	public function ajouter() {
		/**
		 * *********************************************
		 * Affichage enregistrement vide pour ajout
		 * *********************************************
		 */
		$element = $this->mail->emptyRecord();
		$element['hide_id'] = '';
		$this->smarty->assign('element', $element);
		$this->affiche("form");
	}

	public function enregistrer() {
		/**
		 * *********************************************
		 * Enregistrement modification
		 * *********************************************
		 */
		$id = $_POST ['id'];

		// TEST Doublon...
		if (empty($_POST['hide_id'])) {
			// si Doublon...
			if ($this->mail->find('id', $id)) {
				$this->message('Ce code mail est déjà utilisé', 'error');
				$this->smarty->assign('element', $_POST);
				$this->affiche("form");
				return;
			}
		}
		// saisie valide -> mise à jour base
		if (empty($_POST['hide_id'])) {
			// INSERT
			$mail = new mail();
			$mail->setFrom($_POST['mailfrom']);
			$mail->addAddress($_POST['mailto']);
			$mail->Subject=$_POST['subject'];
			$mail->msgHTML($_POST['body']);
			$mail->sendEmail();
			$this->message('Le mail a été envoyé');
		} else {
			// UPDATE
			$mail = $this->mail->find('id', $id);
			if ($mail) {
				$objmail = unserialize(base64_decode($mail['serialization']));
				if (SMTP_HOST != '') {
					$objmail->Host = SMTP_HOST;
					$objmail->Port = SMTP_PORT;
					$objmail->isSMTP();
				}

				$retour = $objmail->send();
				if (!$retour)
					$error = $objmail->ErrorInfo;
				else
					$error = '';
				$this->mail->update('id', $id, ['mailerror' => $error]);
				$this->message('Le mail a été renvoyé. ' . $error);
			}
		}

		unset($_POST);
		$this->liste();
	}

	public function autocomplete() {
		$search = "%" . sql_escape($_GET['term']) . "%";
		$data = $this->mail->query("SELECT TOP 1000 nomuti+' '+preuti+'('+mail+')' as label ,mail as value from UTILISATEURS where nomuti like :nomuti and preuti like :preuti and mail like :adrmel order by mail", array('nomuti' => $search, 'preuti' => $search, 'adrmel' => $search));
		echo json_encode($data);
	}

}

?>