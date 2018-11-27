<?php

class Pont
{
    private $ville1;
    private $ville2;
    private $nbVoies;
    private $horizontal;

    function __construct($v1, $v2, $horizontal){
        $this->ville1 = $v1;
        $this->ville2 = $v2;
        $this->nbVoies = 1;
        $this->horizontal = $horizontal;
    }

    public function getVille1(){
        return $this->ville1;
    }

    public function getVille2(){
        return $this->ville2;
    }

    public function estHorizontal() {
        return $this->horizontal;
    }

    function setNbVoies($nbVoies){
        $this->nbVoies = $nbVoies;
    }

    function getNbVoies(){
        return $this->nbVoies;
    }

    /**
     * @return int nombre de pont(s) ajouté(s) ou supprimé(s)
     */
    function ajouterVoie(){
        $ancienneValeur = $this->nbVoies;
        $this->nbVoies = ($this->nbVoies + 1) % 3;
        $difference = $this->nbVoies - $ancienneValeur;
        return $difference;
    }

    public function equals($pont){
        $equals = false;
        if($this->ville1->getId() == $pont->ville1->getId() &&
            $this->ville2->getId() == $pont->ville2->getId()){
            $equals = true;
        }
        return $equals;
    }

}