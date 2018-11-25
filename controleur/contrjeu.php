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
        if(isset($_SESSION["selected"])){
            unset($_SESSION["selected"]);
        }
		$this->vue->jeu();
	}

	public function jouer($x, $y){
	    // si une case n'a pas encore ete selectionnée ou que le case cliquée est celle déjà sélectionnée
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
            // si les deux cases sont sur la même ligne
            if ($_SESSION['selected']['y'] == $y) {
                $sontLiables = $this->sontLiablesLigne($x, $y);
            } else if ($_SESSION['selected']['x'] == $x) {
                // si les deux cases sont sur la même colonne
                $sontLiables = $this->sontLiablesColonne($x, $y);
            } else {
                echo "pas sur même ligne ou même colonne";
            }
        }
        $this->vue->jeu();
    }

    public function sontLiablesColonne($x, $y){
        $miny = min($_SESSION['selected']['y'], $y) + 1;
        $maxy = max($_SESSION['selected']['y'], $y) - 1;
        $sontLiables = true;
        $i=$miny;
        while ($sontLiables && $i <= $maxy){
            if(isset($_SESSION['villes'][$x][$i])){
                $sontLiables = false;
            }
            $i++;
        }
        return $sontLiables;
    }

    public function sontLiablesLigne($x, $y){
        $minx = min($_SESSION['selected']['x'], $x) + 1;
        $maxx = max($_SESSION['selected']['x'], $x) - 1;
        $sontLiables = true;
        $i=$minx;
        // on regarde si il n'y a rien ENTRE les deux, d'où le -1 et le +1
        while ($sontLiables && $i <= $maxx){
            if(isset($_SESSION['villes'][$i][$y])){
                $sontLiables = false;
            }
            $i++;
        }
        return $sontLiables;
    }
}