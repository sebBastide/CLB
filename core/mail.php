<?php

require_once BASE_DIR . 'core/PHPMailer/class.phpmailer.php';
require_once BASE_DIR . 'core/PHPMailer/class.smtp.php';

class mail extends PHPMailer {

	private $tmpdir = 'web/templates_c/tmp/';

	/**
	 * Constructor.
	 * @param boolean $exceptions Should we throw external exceptions?
	 */
	public function __construct($exceptions = false) {
		parent::__construct($exceptions);
		global $connsql;
		$this->tmpdir = BASE_DIR . 'web/templates_c/tmp_' . time();
		if (!file_exists($this->tmpdir))
			mkdir($this->tmpdir);
		if (SMTP_HOST != '') {
			$this->Host = SMTP_HOST;
			$this->Port = SMTP_PORT;
			$this->isSMTP();
		}
//		$this->SMTPDebug=1;
		$this->Debugoutput = 'html';
		$this->CharSet = "UTF-8";
		$connsql->query("CREATE TABLE IF NOT EXISTS MAILS "
				. " (id int NOT NULL, mailto VARCHAR(500) NULL, mailfrom VARCHAR(100) NULL, "
				. "subject VARCHAR(500) NULL,"
				. "body LONGTEXT NULL, "
				. "mailerror VARCHAR(500) NULL, "
				. "serialization LONGTEXT NULL, "
				. "statut VARCHAR(1) NULL ,creuti VARCHAR(30)  NULL, credat date NULL, creheu time NULL, moduti VARCHAR(30)  NULL, moddat date NULL, modheu time NULL); "
				. " ALTER TABLE MAILS ADD PRIMARY KEY (id); "
				. " ALTER TABLE MAILS MODIFY id int NOT NULL AUTO_INCREMENT; ");
	}

	function EmbedImages() {
		preg_match_all('/<img[^>]*src="([^"]*)"/i', $this->Body, $matches);
		if (!isset($matches[0]))
			return;

		foreach ($matches[0] as $index => $img) {
			$id = 'img' . $index;
			$src = $matches[1][$index];
			if (mb_substr($src, 0, 5) != 'data:') {
				$ext = pathinfo($src, PATHINFO_EXTENSION);
				$img = $this->tmpdir . '/' . $id . '.' . $ext;
				copy($src, $img);
				$this->addEmbeddedImage($img, $id, $id . '.' . $ext);
				$this->Body = str_replace($src, 'cid:' . $id, $this->Body);
			}
		}
	}

	/**
	 * 
	 */
		
	function sendEmail() {
		$body=$this->Body;
		$this->EmbedImages();
		$retour = $this->send();
		if (!$retour)
			$error = $this->ErrorInfo;
		else
			$error = '';
		$attach = array();
		$attachname = array();

		for ($i = 0; $i <= 9; $i++) {
			if (isset($this->attachment[$i][0])) {
				$attach[$i] = $this->attachment[$i][0];
				$attachname[$i] = $this->attachment[$i][1];
			} else {
				$attach[$i] = '';
				$attachname[$i] = '';
			}
		}
		$tab_mails = new dbtable("MAILS");
		$tab_mails->insert(array(
			'mailto' => implode(';', $this->to[0]),
			'mailfrom' => $this->From,
			'subject' => $this->Subject,
			'body' => $body,
			'serialization'=>  base64_encode(serialize($this)),
			'mailerror' => $error
		));

		if (is_dir($this->tmpdir))
			rrmdir($this->tmpdir);
		return $retour;
	}

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

