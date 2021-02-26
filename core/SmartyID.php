<?php

require_once BASE_DIR . "core/smarty/Smarty.class.php";
require_once BASE_DIR . "core/menu.php";

// classe smarty etendue
class SmartyID extends Smarty {

	function __construct() {
		parent::__construct();
		$this->template_dir = BASE_DIR . 'views';
		$this->caching = false;
		$this->registerPlugin('modifier', 'dat', 'dat');
		$this->registerPlugin('modifier', 'num', 'num');
	}

	public function displayBase($template) {
		$css = array(
			BASE_URL . "css/jquery-ui.css",
			BASE_URL . "css/texte.css",
			BASE_URL . "css/menu.css",
			BASE_URL . "css/jquery.dataTables.css",
			BASE_URL . "css/uploadify.css",
			BASE_URL . "css/site.css"
				)
		;

		$js = array(
			BASE_URL . "js/jquery.min.js",
			BASE_URL . "js/jquery-ui.min.js",
			BASE_URL . "js/superfish.js",
			BASE_URL . "js/jquery.dataTables.js",
			BASE_URL . "js/jquery.dataTables.scroller.js",
			BASE_URL . "js/jquery.dataTables.colorder.js",
			BASE_URL . "js/jquery.dataTables.colvis.js",
			BASE_URL . "js/jquery.dataTables.tableTools.js",
			BASE_URL . "js/jquery.uploadify.js",
			BASE_URL . "js/swfobject.js",
			BASE_URL . "js/divers.js"
				)
		;
		$this->assign('css', $css);
		$this->assign('js', $js);
		$this->assign('imgpath', BASE_URL . "img");
		$this->assign('base_url', BASE_URL);
		if (isset($_SESSION ['debugs'])) {
			$this->assign('debugs', '<hr><h3 style="background:#ccc"><pre>' . $_SESSION ['debugs'] . '</pre><h2>');
			$_SESSION ['debugs'] = '';
			unset($_SESSION ['debugs']);
		} else {
			$this->assign('debugs', '');
		}
		$this->assign('sessioncoduti', isset($_SESSION['coduti']) ? $_SESSION['coduti'] : '');
		$this->display($template);
	}

	public function displayLayout($page, $titre, $layout = 'templates/base.tpl') {
		$pagephp = str_replace(".tpl", "", explode('/', $page));
		if (auth::$authok) {
			$menu = new menu($pagephp [0]);
			$this->assign('listemenu', $menu->liste);
		} else
			$this->assign('listemenu', ' ');

// assignation des variables et tableaux
		$this->assign('imgpath', BASE_URL . "img");
		$this->assign('base_url', BASE_URL);
		if (isset($_SESSION ['message'])) {
			$this->assign('message', $_SESSION ['message']);
			$_SESSION ['message'] = '';
			unset($_SESSION ['message']);
		} else {
			$this->assign('message', '');
		}
		$this->assign('contenuPage', $this->fetch($page));
		if (empty($_SESSION['imagefond']))
			$_SESSION['imagefond']='/img/charte/fond-site.jpg';
		$this->assign('imagefond', $_SESSION['imagefond']);
		$this->assign('titrepage', $titre);
		$this->displayBase($layout);
	}

	public function pdf($page, $titre = 'Document PDF',$filename='',$return='I') {
		$this->assign('titrepage', $titre);
		$this->assign('base_url', BASE_URL);

		if ($return == 'debug') {
			$this->display($page);
		} else {
			$content = $this->fetch($page);
			try {
				require_once(BASE_DIR . 'core/html2pdf/html2pdf.class.php');
				$html2pdf = new HTML2PDF('P', 'A4', 'fr');
				$html2pdf->pdf->SetTitle($titre);
//				$content = $html2pdf->getHtmlFromPage($content);
				$html2pdf->setDefaultFont('helvetica');
				ob_end_clean();
				$html2pdf->writeHTML($content);
				return $html2pdf->Output($filename,$return);
			} catch (Exception $e) {
				die($e);
			}
		}
	}

}
