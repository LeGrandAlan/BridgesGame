<?php

require "Pont.php";

/**
 * Class Ponts
 */
class Ponts
{
    public $ponts;


    /**
     * Constucteur de Ponts
     */
    function __construct(){
        $this->ponts = array();
    }

    /**
     * Donne l'object pont ayant les attributs suivants
     * @param $v1 Ville de départ (sélectionné)
     * @param $v2 Ville d'arrivé (sélectionné)
     * @param $horizontal boolean vrai si le pont est sur une ligne, faux si sur une colonne
     * @return Pont pont qui a ces attributs
     */
    public function getPont($v1, $v2, $horizontal) {
        $trouve = false;
        $i = 0;

        if($v1->compareTo($v2) <= 0){
            $pont = new Pont($v1, $v2, $horizontal);
        } else {
            $pont = new Pont($v2, $v1, $horizontal);
        }

        while (!$trouve && $i < sizeof($this->ponts)) {
            if(isset($this->ponts[$i]) && $this->ponts[$i]->equals($pont)) {
                $trouve = true;
            }
            $i++;
        }
        return $this->ponts[$i - 1];
    }

    /**
     * Retourne le pont (si'il existe) qui correspont au hash donnée en paramètre
     * @param $hash string à comparer avec les pont dans le grille
     * @return Pont|null retourne le pont si il y est, null sinon
     */
    public function getPontParHash($hash) {
        for($i = 0; $i < sizeof($this->ponts); $i++) {
            if(isset($this->ponts[$i]) && ($this->ponts[$i]->hash() == $hash)) {
                return $this->ponts[$i];
            }
        }
        return null;
    }

    /**
     * Ajoute un pont
     * @param $v1 Ville sélectionnée comme départ du pont
     * @param $v2 Ville sélectionnée comme arrivé du pont
     * @param $horizontal boolean vrai si le pont est sur une ligne, faux si sur une colonne
     */
    public function ajoutPont($v1, $v2, $horizontal) {
        //la ville ayant l'id le plus petit est le départ => pour que les deux sens soient prient en compte
        if($v1->compareTo($v2) <= 0){
            array_push($this->ponts, new Pont($v1, $v2, $horizontal));
        } else {
            array_push($this->ponts, new Pont($v2, $v1, $horizontal));
        }
    }

    public function ajoutPontSimple($pont) {
        array_push($this->ponts, $pont);
    }

    /**
     * Supprime le pont
     * @param $pont Pont a supprimer
     */
    public function supprimerPont($pont) {
        // on va tester si il y a deux voies, dans ce cas là on enlève une voie sinon on le supprime
        if($pont->getNbVoies() == 2) {
            $pont->setNbVoies(1);
        } else {
            $pont->setNbVoies(0);
            unset($this->ponts[array_search($pont, $this->ponts)]); //on supprime le pont de la liste des ponts
            $this->ponts = array_values($this->ponts); //on réindex pour que les ponts soient à des index qui se suivent
        }
    }

    /**
     * Indique si un pont existe
     * @param $v1 Ville sélectionnée comme départ du pont
     * @param $v2 Ville sélectionnée comme arrivé du pont
     * @param $horizontal boolean vrai si le pont est sur une ligne, faux si sur une colonne
     * @return bool vrai si le pont existe, faux sinon
     */
    public function pontExiste($v1, $v2, $horizontal) {
        $existe = false;
        $i = 0;

        if($v1->compareTo($v2) < 0){
            $pont = new Pont($v1, $v2, $horizontal);
        } else {
            $pont = new Pont($v2, $v1, $horizontal);
        }

        while (!$existe && $i < sizeof($this->ponts)) {
            if(isset($this->ponts[$i]) && $this->ponts[$i]->equals($pont)) {
                $existe = true;
            }
            $i++;
        }
        return $existe;
    }

    /**
     * Génère une matrice avec les ponts dessinés
     * @return array matrice (2D -> deux tableaux)
     */
    public function matricePonts(){
        $matrice = null;
        $villes = new Villes(); //pour récupérer les coordonnées

        foreach($this->ponts as $pont) {
            $nbVoies = $pont->getNbVoies();
            $coordv1 = $villes->getCoord($pont->getVille1());//plus en haut / à gauche
            $coordv2 = $villes->getCoord($pont->getVille2());//plus en bas / à droite

            if($pont->estHorizontal() == true) {
                for($x=$coordv1['x']+1; $x <= $coordv2['x']-1; $x++) {
                    if ($nbVoies == 1){
                        $matrice[$x][$coordv1['y']] = 'h1'; // 1 voie horizontalle
                    } else if($nbVoies == 2) {
                        $matrice[$x][$coordv1['y']] = 'h2'; // 2 voies horizontalles
                    }
                }
            } else {
                for($y=$coordv1['y']+1; $y <= $coordv2['y']-1; $y++) {
                    if ($nbVoies == 1){
                        $matrice[$coordv1['x']][$y] = 'v1'; // 1 voie verticale
                    } else if($nbVoies == 2) {
                        $matrice[$coordv1['x']][$y] = 'v2'; // 2 voies vertiales
                    }
                }
            }
        }
        return $matrice;
    }

}