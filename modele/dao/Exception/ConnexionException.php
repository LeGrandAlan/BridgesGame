<?php
require_once 'DaoException.php';

/**
 * Class ConnexionException
 */
class ConnexionException extends DaoException{

    /**
     * ConnexionException constructor.
     * @param $chaine string message d'erreur
     */
    public function __construct($chaine) {
        parent::__construct($chaine);
    }

}