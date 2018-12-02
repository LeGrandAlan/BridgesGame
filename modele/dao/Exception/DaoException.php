<?php


class DaoException extends Exception{

    private $chaine;

    public function __construct($chaine){
        parent::__construct($chaine);
        $this->chaine = $chaine;
    }

    public function afficher(){
        return $this->chaine;
    }
}