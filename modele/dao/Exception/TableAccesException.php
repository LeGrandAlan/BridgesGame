<?php
require_once 'DaoException.php';

/**
 * Class TableAccesException
 */
class TableAccesException extends DaoException{

    /**
     * TableAccesException constructor.
     * @param $chaine string message d'erreur
     */
    public function __construct($chaine) {
        parent::__construct($chaine);
    }

}