<?php
require_once PATH_VUE.'/jeu.php';
require_once PATH_MODELE.'/Villes.php';

class Contrjeu{

	private $vue;
	private $modele;

	public function __construct() {
		$this->vue = new VueJeu();
		$this->modele = new Villes();
	}

	//TODO: attention ne marche que pour grille de 7*7
	public function init_jeu(){
        for($x = 0; $x < 7; $x++){
            for($y = 0; $y < 7; $y++){
                if($this->modele->existe($x, $y)){
                    $_SESSION['villes'][$x][$y] = array(
                        'nbPontsMax' => $this->modele->getVille($x, $y)->getNombrePontsMax(),
                        'nbPontsActuels' => $this->modele->getVille($x, $y)->getNombrePonts(),
                        'estSelectionne' => false
                    );
                }
            }
        }
		$this->vue->jeu();
	}

	public function jouer($x, $y){
	    // si une case n'a pas encore ete selectionnée
	    if(!isset($_SESSION['selected']) || ($_SESSION['selected']['x'] == $x && $_SESSION['selected']['y'] == $y )){
	        // si la case cliquée est la case deja selectionnée
            if(isset($_SESSION['selected']) && $_SESSION['selected']['x'] == $x && $_SESSION['selected']['y'] == $y ){
	            unset($_SESSION['selected']);
            } else {
                $_SESSION['selected'] = array('x' => $x, 'y' => $y);
            }
            //inverse la case cliquée
            $_SESSION['villes'][$x][$y]['estSelectionne'] = !$_SESSION['villes'][$x][$y]['estSelectionne'];
        } else {
            // on va regarder si les deux villes sont liables
            echo "voir si 2 villes liables";
        }
        $this->vue->jeu();
    }
}