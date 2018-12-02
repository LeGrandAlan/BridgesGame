<?php
require_once 'DaoException.php';

class ConnexionException extends DaoException{

    public function __construct($chaine) {
        parent::__construct($chaine);
    }

}