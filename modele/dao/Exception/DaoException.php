<?php

/**
 * Class DaoException
 */
class DaoException extends Exception{

    private $chaine;

    /**
     * DaoException constructor.
     * @param $chaine
     */
    public function __construct($chaine){
        parent::__construct($chaine);
        $this->chaine = $chaine;
    }

    /**
     * Méthode qui retourne le message d'erreur
     * @return string message d'erreur
     */
    public function afficher(){
        return $this->chaine;
    }
}