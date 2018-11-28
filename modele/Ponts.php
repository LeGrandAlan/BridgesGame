<?php

require "Pont.php";
//require "Ville.php";

class Ponts
{
    public $ponts;

    function __construct(){
        $this->ponts = array();
    }

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

    //TODO: faire en sorte que les ponts soient les même dans les deux sens

    public function ajoutPont($v1, $v2, $horizontal) {
        //la ville ayant l'id le plus petit est le départ => pour que les deux sens soient prient en compte
        if($v1->compareTo($v2) <= 0){
            array_push($this->ponts, new Pont($v1, $v2, $horizontal));
        } else {
            array_push($this->ponts, new Pont($v2, $v1, $horizontal));
        }
    }

    public function supprimerPont($pont) {
        unset($this->ponts[array_search($pont, $this->ponts)]);
    }

    public function pontExiste($v1, $v2, $horizontal) {
        $existe = false;
        $i = 0;

        if($v1->compareTo($v2) <= 0){
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
                        $matrice[$x][$coordv1['y']] = '-';
                    } else if($nbVoies == 2) {
                        $matrice[$x][$coordv1['y']] = '=';
                    } else {
                        $matrice[$x][$coordv1['y']] = 'X';
                    }
                }
            } else {
                for($y=$coordv1['y']+1; $y <= $coordv2['y']-1; $y++) {

                    if ($nbVoies == 1){
                        $matrice[$coordv1['x']][$y] = '|';
                    } else if($nbVoies == 2) {
                        $matrice[$coordv1['x']][$y] = '||';
                    } else {
                        $matrice[$coordv1['x']][$y] = 'X';
                    }
                }
            }
        }
        return $matrice;
    }

}