<?php
require_once PATH_VUE . '/VueJeu.php';
require_once PATH_MODELE.'/Villes.php';
require_once PATH_MODELE.'/Ville.php';
require_once PATH_MODELE.'/Ponts.php';

/**
 * Class ControlleurJeu.
 * Controlleur qui gère le jeu.
 */
class ControlleurJeu {

    private $vue;
    private $modeleVilles;
    private $modelePonts;
    private $pilePonts;

    /**
     * ControlleurJeu constructor.
     */
    public function __construct() {
        $this->vue = new VueJeu();
    }

    /**
     * Méthode qui initialise toutes les variables de sessions
     * et affiche la grille de jeu de base
     */
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
        if(isset($_SESSION['pile_ponts'])) {
            unset($_SESSION['pile_ponts']);
        }

        $this->modeleVilles = new Villes();
        $_SESSION['villes'] = serialize($this->modeleVilles);
        $this->modelePonts = new Ponts();
        $_SESSION['ponts'] = serialize($this->modelePonts);
        $this->pilePonts = [];
        $_SESSION['pile_ponts'] = serialize($this->pilePonts);

        $this->vue->jeu();
    }

    /**
     * Méthode qui permet de gérer le tour de jeu de l'utilisateur
     * @param $x int coordonnée x de la ville sélectionnée
     * @param $y int coordonnée y de la ville sélectionnée
     */
    public function jouer($x, $y){
        //chargement des villes et des ponts en utilisant leurs modèles
        $this->modeleVilles = unserialize($_SESSION['villes']);
        $this->modelePonts = unserialize($_SESSION['ponts']);
        $this->pilePonts = unserialize($_SESSION['pile_ponts']);

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

                // on regarde si les villes sont liables (qu'il n'y a pas d'autre ville entre les deux)
                $horizontal = null;
                if($this->modeleVilles->sontLiablesHorizontalement($ville1, $ville2, $this->modelePonts)){
                    $horizontal = true;
                } else if($this->modeleVilles->sontLiablesVerticalement($ville1, $ville2, $this->modelePonts)) {
                    $horizontal = false;
                } else {
                    //ne sont pas liables => il y a un pont ou une ville entre les deux villes
                    $_SESSION['erreur'] = "Les villes ne sont pas liables car il y a une ville ou un pont entre les deux villes sélectionnée !";
                    $this->vue->jeu();
                    return;
                }

                //ajout du pont sur la "carte" des ponts

                if($this->modelePonts->pontExiste($ville1, $ville2, $horizontal)){
                    $pont = $this->modelePonts->getPont($ville1, $ville2, $horizontal);
                    $differencePont = $pont->ajouterVoie($ville1, $ville2);
                    $this->pilePonts[sizeof($this->pilePonts)][$pont->hash()] = $pont;
                    if($differencePont == -2) {
                        $this->modelePonts->supprimerPont($pont);
                        // on supprime la liaison entre les villes
                        $ville1->supprimerVilleLiee($ville2);
                        $ville2->supprimerVilleLiee($ville1);
                    } else {
                        //ajout des liaisons entre chaque villes
                        $ville1->ajouterVilleLiee($ville2);
                        $ville2->ajouterVilleLiee($ville1);
                    }
                } else {
                    $this->modelePonts->ajoutPont($ville1, $ville2, $horizontal);
                    $differencePont = 1;
                    $pont = new Pont($ville1, $ville2, $horizontal);
                    $this->pilePonts[sizeof($this->pilePonts)][$pont->hash()] = $pont;

                    //ajout des liaisons entre chaque villes
                    $ville1->ajouterVilleLiee($ville2);
                    $ville2->ajouterVilleLiee($ville1);
                }

                //ajout ou suppression de pont(s) à chaque ville
                $ville1->setNombrePonts($ville1->getNombrePonts() + $differencePont);
                $ville2->setNombrePonts($ville2->getNombrePonts() + $differencePont);

                unset($_SESSION['selectionne']);

            } else {
                $_SESSION['erreur'] = "Vous ne pouvez pas créer de pont entre ces deux villes !";
            }
        }

        if($this->modeleVilles->sontToutesBonnes()){
            $_SESSION['gagne'] = true;
            header('Location: index.php?resultat');
        }

        //sauvegarde des modèles en variables de session (pour lecture par la vue et par ce controlleur plus tard)
        $_SESSION['villes'] = serialize($this->modeleVilles);
        $_SESSION['ponts'] = serialize($this->modelePonts);
        $_SESSION['pile_ponts'] = serialize($this->pilePonts);

        $this->vue->jeu();
        echo "<pre>";
        var_dump($this->modeleVilles);
        echo "</pre>";
    }

    /**
     * Méthode qui revient au coup précédent
     */
    public function annulerPrecedent() {
        $this->modeleVilles = unserialize($_SESSION['villes']);
        $this->modelePonts = unserialize($_SESSION['ponts']);
        $this->pilePonts = unserialize($_SESSION['pile_ponts']);

        if(!empty($this->pilePonts)){
            $dernierPont = $this->pilePonts[sizeof($this->pilePonts)-1];
            $hashPont = key($dernierPont);
            $pont = $this->modelePonts->getPontParHash($hashPont);
            if($pont==null) { // si le pont n'existe pas (il a été supprimé du plateau) alors on prend l'objet Pont enregistré et on le recrer
                $pont = $dernierPont[$hashPont];
            }

            $coordville1 = $this->modeleVilles->getCoord($pont->getVille1());
            $coordville2 = $this->modeleVilles->getCoord($pont->getVille2());

            //si le pont a été supprimé, alors on va le rajouter
            if($pont->getNbVoies() == 0) {
                $pont->setNbVoies(2);
                $this->modelePonts->ajoutPontSimple($pont);
                $this->modeleVilles->setVille($coordville1['x'], $coordville1['y'], 1);
                $this->modeleVilles->setVille($coordville2['x'], $coordville2['y'], 1);
                //on récupère les villes nouvellement créées
                $ville1 = $this->modeleVilles->getVille($coordville1['x'], $coordville1['y']);
                $ville2 = $this->modeleVilles->getVille($coordville2['x'], $coordville2['y']);
                //ajout des liaisons entre chaque villes TODO: ne marche pas quand il faut rajouter les liaisons et que pendant on rajoute une autre liaison avec une autre ville
                var_dump($ville1);
                echo "test";
                $ville1->ajouterVilleLiee($ville2);
                echo "<br><br>";
                var_dump($ville1); // l'ajout marche bien mais ne passe pas à l'ajout 2
                echo "test 2";
                echo "<br><br>";
                var_dump($ville2);
                $ville2->ajouterVilleLiee($ville1);
                echo "test 3";
            } else {
                // il faut enlever une ville /!\ il faut voir si il n'y a plus de pont et dans ce cas la le supprimer
                $this->modelePonts->supprimerPont($pont);

                $this->modeleVilles->setVille($coordville1['x'], $coordville1['y'], -1);
                $this->modeleVilles->setVille($coordville2['x'], $coordville2['y'], -1);

                $ville1 = $this->modeleVilles->getVille($coordville1['x'], $coordville1['y']);
                $ville2 = $this->modeleVilles->getVille($coordville2['x'], $coordville2['y']);

                if($pont->getNbVoies() == 0) { //si il n'y a plus de voies sur le pont, on le supprime
                    unset($pont);
                    // on supprime la liaison entre les villes
                    $ville1->supprimerVilleLiee($ville2);
                    $ville2->supprimerVilleLiee($ville1);
                }
            }

            unset($this->pilePonts[sizeof($this->pilePonts) - 1]);

        } else {
            $_SESSION['erreur'] = "Vous ne pouvez pas revenir en arrière";
        }

        //TODO: faire une fonction pour ça
        $_SESSION['villes'] = serialize($this->modeleVilles);
        $_SESSION['ponts'] = serialize($this->modelePonts);
        $_SESSION['pile_ponts'] = serialize($this->pilePonts);

        $this->vue->jeu();
        echo "<pre>";
        var_dump($this->modeleVilles);
        echo "</pre>";
    }

}