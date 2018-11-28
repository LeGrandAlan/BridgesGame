<?php
require_once PATH_VUE.'/jeu.php';
require_once PATH_MODELE.'/Villes.php';
require_once PATH_MODELE.'/Ville.php';
require_once PATH_MODELE.'/Ponts.php';

class Contrjeu{

	private $vue;
	private $modeleVilles;
	private $modelePonts;

	public function __construct() {
		$this->vue = new VueJeu();
	}

	//TODO: attention ne marche que pour grille de 7*7
	public function init_jeu(){
        if(isset($_SESSION["selectionne"])){
            unset($_SESSION["selectionne"]);
        }
        if(isset($_SESSION['villes'])){
            unset($_SESSION['villes']);
        }
        if(isset($_SESSION['ponts'])){
            unset($_SESSION['ponts']);
        }

        $this->modeleVilles = new Villes();
        $_SESSION['villes'] = serialize($this->modeleVilles);
        $this->modelePonts = new Ponts();
        $_SESSION['ponts'] = serialize($this->modelePonts);


		$this->vue->jeu();
	}

	public function jouer($x, $y){
	    //chargement des villes et des ponts en utilisant leurs modèles
        $this->modeleVilles = unserialize($_SESSION['villes']);
        $this->modelePonts = unserialize($_SESSION['ponts']);

	    // si une case n'a pas encore été selectionnée ou que le case cliquée est celle déjà sélectionnée
        if(!isset($_SESSION['selectionne']) || ($_SESSION['selectionne']['x'] == $x && $_SESSION['selectionne']['y'] == $y )){
            // si la case cliquée est la case deja selectionnée
            if(isset($_SESSION['selectionne']) && $_SESSION['selectionne']['x'] == $x && $_SESSION['selectionne']['y'] == $y ){
                unset($_SESSION['selectionne']); //déselection
            } else {
                $_SESSION['selectionne'] = array('x' => $x, 'y' => $y); //selection
            }
        } else { // si une case est déjà sélectionnée et que l'utilisateur vient d'en selectionner une deuxième

            // si les deux cases sont sur la même ligne ou colonne
            if ($_SESSION['selectionne']['y'] == $y || $_SESSION['selectionne']['x'] == $x) {

                $ville1 = $this->modeleVilles->getVille($_SESSION['selectionne']['x'], $_SESSION['selectionne']['y']);
                $ville2 = $this->modeleVilles->getVille($x, $y);

                $horizontal = null;
                if($this->sontLiablesHorizontalement($x, $y)){
                    $horizontal = true;
                } else if($this->sontLiablesVerticalement($x, $y)) {
                    $horizontal = false;
                } else {
                    //ne sont pas liables => il y a un pont ou une ville entre les deux villes
                    echo "Les villes ne sont pas liables car il y a une ville ou un pont entre les deux villes sélectionnée !";
                    $this->vue->jeu();
                    return;
                }

                //ajout du pont sur la "carte" des ponts
                if($this->modelePonts->pontExiste($ville1, $ville2, $horizontal)){
                    $pont = $this->modelePonts->getPont($ville1, $ville2, $horizontal);
                    $differencePont = $pont->ajouterVoie($ville1, $ville2);
                    if($differencePont == -2) {
                        $this->modelePonts->supprimerPont($pont);
                    }
                } else {
                    $this->modelePonts->ajoutPont($ville1, $ville2, $horizontal);
                    $differencePont = 1;
                }

                //ajout ou suppression de pont(s) à chaque ville
                $ville1->setNombrePonts($ville1->getNombrePonts() + $differencePont);
                $ville2->setNombrePonts($ville2->getNombrePonts() + $differencePont);

                unset($_SESSION['selectionne']);

            } else {
                echo "Vous ne pouvez pas créer de pont entre ces deux villes !";
            }

        }

        if($this->modeleVilles->sontToutesBonnes()){
            echo "ET C'EST GAGNE !!!";
        }

        //sauvegarde des modèles en variables de session (pour lecture par la vue et par ce controlleur plus tard)
        $_SESSION['villes'] = serialize($this->modeleVilles);
        $_SESSION['ponts'] = serialize($this->modelePonts);

        $this->vue->jeu();
    }

    public function sontLiablesVerticalement($x, $y){
        $miny = min($_SESSION['selectionne']['y'], $y) + 1;
        $maxy = max($_SESSION['selectionne']['y'], $y) - 1;

        $sontLiables = !($miny > $maxy);//si min et max sont = ou max plus petit alors false sinon true
        $i=$miny;
        $matricePonts = $this->modelePonts->matricePonts();
        while ($sontLiables && $i <= $maxy){ //TODO: rendre plus propre $matricePonts...
            if($this->modeleVilles->existe($x, $i) || isset($matricePonts[$x][$i])){
                $sontLiables = false;
            }
            $i++;
        }
        return $sontLiables;
    }

    public function sontLiablesHorizontalement($x, $y){
        $minx = min($_SESSION['selectionne']['x'], $x) + 1;
        $maxx = max($_SESSION['selectionne']['x'], $x) - 1;

        $sontLiables = !($minx > $maxx);//si min et max sont = ou max plus petit alors false sinon true
        $i=$minx;
        $matricePonts = $this->modelePonts->matricePonts();
        // on regarde si il n'y a pas de ville ENTRE les deux, d'où le -1 et le +1

        //TODO: il faut tester si un pont existe déjà et qu'on est sur ce pont, dans ce sens là (horizontal)
        // on va tester si la première ville est lié avec la deuxième

        while ($sontLiables && $i <= $maxx){ //TODO: rendre plus propre $matricePonts...
            if($this->modeleVilles->existe($i, $y) || isset($matricePonts[$i][$y])){
                $sontLiables = false;
            }
            $i++;
        }
        return $sontLiables;
    }
}