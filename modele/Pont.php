<?php

/**
 * Class Pont
 */
class Pont
{
    private $ville1;
    private $ville2;
    private $nbVoies;
    private $horizontal;

    /**
     * Constructeur de Pont
     * @param $v1 Ville sélectionnée comme départ du pont
     * @param $v2 Ville sélectionnée comme arrivé du pont
     * @param $horizontal boolean vrai si le pont est sur une ligne, faux si sur une colonne
     */
    function __construct($v1, $v2, $horizontal){
        $this->ville1 = $v1;
        $this->ville2 = $v2;
        $this->nbVoies = 1;
        $this->horizontal = $horizontal;
    }

    /**
     * Retoune la ville de départ du pont
     * @return Ville ville de départ du pont
     */
    public function getVille1(){
        return $this->ville1;
    }

    /**
     * Retoune la ville d'arrive du pont
     * @return Ville ville d'arrive du pont
     */
    public function getVille2(){
        return $this->ville2;
    }

    /**
     * Indique qi le pont est horizontal
     * @return bool vrai si le pont est sur une ligne, faux s'il est sur une colonne
     */
    public function estHorizontal() {
        return $this->horizontal;
    }

    /**
     * Indique le nombre de voies du pont
     * @return int nombre de voies du pont (0, 1 ou 2)
     */
    function getNbVoies(){
        return $this->nbVoies;
    }

    function setNbVoies($nb){
        $this->nbVoies = $nb;
    }

    /**
     * Ajoute une voie sauf si il y en a déjà 2 -> 0 voie dans ce cas là
     * @return int nombre de pont(s) ajouté(s) ou supprimé(s)
     */
    function ajouterVoie(){
        $ancienneValeur = $this->nbVoies;
        $this->nbVoies = ($this->nbVoies + 1) % 3;
        $difference = $this->nbVoies - $ancienneValeur;
        return $difference;
    }

    /**
     * Indique si les deux ponts sont égaux
     * @param $pont Pont à tester avec celui là
     * @return bool vrai si les deux ponts sont égaux (leur id), faux sinon
     */
    public function equals($pont){
        $equals = false;
        if($this->ville1->getId() == $pont->ville1->getId() &&
            $this->ville2->getId() == $pont->ville2->getId()){
            $equals = true;
        }
        return $equals;
    }

    /**
     * Retourne le hash du pont
     * @return string hash de ce pont
     */
    public function hash() {
        return $this->ville1->getId() . '-' . $this->ville2->getId() . '-' . $this->estHorizontal();
    }

}