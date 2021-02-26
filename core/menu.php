<?php
/* * **************************************************
 * 													  *
 * 	Classe de génération du menu et du sous-menu	  *
 * 													  *
 * ************************************************** */
class menu {
    /**
     * chaine contenant le menu
     */
    public $liste = "";
    /**
     *  PAGE  ACTIVE 
     */
    private $page;
    /**
     * constructeur
     */
    function __construct($page) {
        $this->page = $page;
        $this->liste = '<div id="menu">
		<ul class="left" style="display: none;">' . PHP_EOL;
        /*
         * *** CHARGEMENT DU MENU ***
         */
        if (isset($_SESSION['menus'])) {
            $options = $_SESSION['menus'];
        } else {
            $menus = new dbtable('MENUS');
            $options = $menus->query("SELECT idmenu,menu,page,idparent,img FROM MENUS WHERE statut='A'  and idparent=0 AND grputi='" . auth::$auth ['grputi'] . "' ORDER BY ordre");

            foreach ($options as $k => $option) {
                if (trim($option ['page']) == '') {
                    $option ['page'] = $menus->query("SELECT idmenu,menu,page,idparent FROM MENUS WHERE statut='A'  and idparent=" . $option ['idmenu'] . " ORDER BY ordre");
                    foreach ($option ['page'] as $k2 => $option2) {
                        if (trim($option2 ['page']) == '') {
                            $option2 ['page'] = $menus->query("SELECT idmenu,menu,page,idparent FROM MENUS WHERE statut='A'  and idparent=" . $option2 ['idmenu'] . " ORDER BY ordre");
                            $option ['page'] [$k2] = $option2;
                        }
                    }
                }
                $options [$k] = $option;
            }
            $_SESSION['menus'] = $options;
        }
        // RECHERCHE PAGE EN COURS
        foreach ($options as $k => $option) {
            $option['selected'] = '';
            if ($option ['page'] == $page)
                $option['selected'] = 'selected';
            if (is_array($option ['page'])) {
                foreach ($option ['page'] as $k2 => $option2) {
                    if ($option2 ['page'] == $page)
                        $option['selected'] = 'selected';
                    if (is_array($option2 ['page'])) {
                        foreach ($option2 ['page'] as $option3) {
                            if ($option3 ['page'] == $page)
                                $option['selected'] = 'selected';
                        }
                    }
                }
            }
			if ($option['selected'] == 'selected')
				$_SESSION['imagefond']=$option['img'];
            $options [$k] = $option;
        }

        // CONSTRUCTION DE LA LISTE DU MENU
        foreach ($options as $k => $option) {
            if (!is_array($option ['page'])) {
                $this->liste .= '<li id="' . $option ['menu'] . '"><a href="' . BASE_URL . $option ['page'] . '" class="top ' . $option['selected'] . '" >' . $option ['menu'] . '</a></li>' . PHP_EOL;
            } else {
                $this->liste .= '<li id="' . $option ['menu'] . '"><a class="top ' . $option['selected'] . '">' . $option ['menu'] . '</a>' . PHP_EOL;
                $this->liste .= '<ul>' . PHP_EOL;
                foreach ($option['page'] as $option2) {
                    if (!is_array($option2 ['page'])) {
                        $this->liste .= '<li><a href="' . BASE_URL . $option2 ['page'] . '">' . $option2 ['menu'] . '</a></li>' . PHP_EOL;
                    } else {
                        $this->liste .= '<li><a class="idparent">' . $option2 ['menu'] . '</a>' . PHP_EOL;
                        $this->liste .= '<ul>' . PHP_EOL;
                        foreach ($option2 ['page'] as $option3) {
                            $this->liste .= '<li><a href="' . BASE_URL . $option3 ['page'] . '">' . $option3 ['menu'] . '</a></li>' . PHP_EOL;
                        }
                        $this->liste .= '</ul></li>' . PHP_EOL;
                    }
                }
                $this->liste .= '</ul></li>' . PHP_EOL;
            }
        }
        $this->liste .= '</ul></div>' . PHP_EOL;
    }
}
