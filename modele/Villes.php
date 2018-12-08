<?php
// cette classe ne doit pas être modifiée
require "Ville.php";

class Villes{

    private $villes;

    /**
     * Constructeur de Villes
     */
    function __construct(){
        // tableau représentatif d'un jeu qui servira à développer votre code
        /*$this->villes[0][0]=new Ville("0",3,0);
        $this->villes[0][6]=new Ville("1",2,0);
        $this->villes[3][0]=new Ville("2",6,0);
        $this->villes[3][5]=new Ville("3",2,0);
        $this->villes[5][1]=new Ville("4",1,0);
        $this->villes[5][6]=new Ville("5",2,0);
        $this->villes[6][0]=new Ville("6",2,0);*/

        $this->villes[0][0]=new Ville("0",3,0);
        $this->villes[0][4]=new Ville("1",3,0);
        $this->villes[0][6]=new Ville("2",2,0);

        $this->villes[1][3]=new Ville("3",2,0);
        $this->villes[1][5]=new Ville("4",1,0);

        $this->villes[3][3]=new Ville("5",4,0);
        $this->villes[3][6]=new Ville("6",4,0);

        $this->villes[4][0]=new Ville("7",2,0);
        $this->villes[4][4]=new Ville("8",2,0);

        $this->villes[5][3]=new Ville("9",1,0);

        $this->villes[6][0]=new Ville("10",2,0);
        $this->villes[6][2]=new Ville("11",1,0);
        $this->villes[6][4]=new Ville("12",4,0);
        $this->villes[6][6]=new Ville("13",3,0);
    }


    // précondition: la ville en position $i et $j existe
    /**
     * Sélecteur qui retourne la ville en position $i et $j
     * @param $i int position horizontale
     * @param $j int position verticale
     * @return Ville ville à la position donnée
     */
    function getVille($i, $j){
        return $this->villes[$i][$j];
    }


    // précondition: la ville en position $i et $j existe
    /**
     * Modifieur qui value le nombre de ponts de la ville en position $i et $j
     * @param $i int position horizontale
     * @param $j int position verticale
     * @param $nombrePonts int nombre de pont a ajouter (+) ou a enlever (-)
     */
    function setVille($i, $j, $nombrePonts){
        $this->getVille($i, $j)->setNombrePonts($this->getVille($i, $j)->getNombrePonts() + $nombrePonts);
    }


    // postcondition: vrai si la ville existe, faux sinon
    /**
     * Permet de tester si la ville en position $i et $j existe
     * @param $i int position horizontale
     * @param $j int position verticale
     * @return bool vrai si une ville exite à la position donnée, faux sinon
     */
    function existe($i, $j){
        return isset($this->villes[$i][$j]);
    }

    //rajout d'éventuelles méthodes

    /**
     * Sélecteur qui retourne les coordonnées de la ville
     * @param $ville Ville ville à trouver
     * @return array|null tableau avec les coordonnées | rien si il n'y a pas de ville
     */
    public function getCoord($ville){
        for ($i=0; $i < 7; $i++) {
            for ($j=0; $j < 7; $j++) {
                if($this->existe($i, $j)){
                    if($this->getVille($i, $j)->equals($ville)) {
                        return array('x' => $i, 'y' => $j);
                    }
                }
            }
        }
        return null;
    }

    /**
     * Indique si toutes les villes ont le même nombre de ponts que leur nombre maximum
     * @return bool vrai "si la grille est gagnante", faux sinon
     */
    public function sontToutesBonnes(){
        for ($i=0; $i < 7; $i++) {
            for ($j=0; $j < 7; $j++) {
                if($this->existe($i, $j)){
                    $ville = $this->getVille($i, $j);
                    if($ville->getNombrePonts() < $ville->getNombrePontsMax()
                        || $ville->getNombrePonts() > $ville->getNombrePontsMax()) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * Indique si les deux villes peuvent être liées sur une colonne (si il n'y a pas de ville entre)
     * @param $ville1 Ville ville de départ
     * @param $ville2 Ville ville d'arrivé
     * @param $ponts Ponts ponts
     * @return bool vrai si sont liables, faux sinon
     */
    public function sontLiablesHorizontalement($ville1, $ville2, $ponts){
        $matricePonts = $ponts->matricePonts();
        $v1Coord = $this->getCoord($ville1);
        $v2Coord = $this->getCoord($ville2);

        $minx = min($v1Coord['x'], $v2Coord['x']) + 1;
        $maxx = max($v1Coord['x'], $v2Coord['x']) - 1;
        $sontLiables = !($minx > $maxx);//si min et max sont = ou max plus petit alors false sinon true

        $i=$minx;
        // on regarde si il n'y a pas de ville ou de pont ENTRE les deux, d'où le -1 et le +1
        while ($sontLiables && $i <= $maxx){
            if($this->existe($i, $v1Coord['y']) ||
                (isset($matricePonts[$i][$v1Coord['y']]) && $matricePonts[$i][$v1Coord['y']][0] == 'v')){//peut importe le y, c'est le même pour les deux villes
                $sontLiables = false;
            }
            $i++;
        }
        return $sontLiables;
    }

    /**
     * Indique si les deux villes peuvent être liées sur une ligne (si il n'y a pas de ville entre)
     * @param $ville1 Ville ville de départ
     * @param $ville2 Ville ville d'arrivé
     * @param $ponts Ponts ponts
     * @return bool vrai si sont liables, faux sinon
     */
    public function sontLiablesVerticalement($ville1, $ville2, $ponts){
        $matricePonts = $ponts->matricePonts();
        $v1Coord = $this->getCoord($ville1);
        $v2Coord = $this->getCoord($ville2);

        $miny = min($v1Coord['y'], $v2Coord['y']) + 1;
        $maxy = max($v1Coord['y'], $v2Coord['y']) - 1;

        $sontLiables = !($miny > $maxy); //si min et max sont = ou max plus petit alors false sinon true
        $i=$miny;
        while ($sontLiables && $i <= $maxy){
            if($this->existe($v1Coord['x'], $i) ||
                (isset($matricePonts[$v1Coord['x']][$i]) && $matricePonts[$v1Coord['x']][$i][0] == 'h')){//peut importe le x, c'est le même pour les deux villes
                $sontLiables = false;
            }
            $i++;
        }
        return $sontLiables;
    }

}
