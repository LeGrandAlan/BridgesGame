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
        $_SESSION['villes'][$x][$y]['estSelectionne'] = !$_SESSION['villes'][$x][$y]['estSelectionne'];
        $this->vue->jeu();
    }
}