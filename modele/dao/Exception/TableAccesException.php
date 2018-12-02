<?php
require_once 'DaoException.php';

class TableAccesException extends DaoException{

    public function __construct($chaine) {
        parent::__construct($chaine);
    }

}