<?php
require_once PATH_DAO . '/DAOResultats.php';
require_once PATH_VUE . '/VueResultats.php';

class ContrResultats {

    private $daoResultats;
    private $vue;

    function __construct() {
        try {
            $this->daoResultats = new DAOResultats();
            $this->vue = new VueResultats();
        } catch (ConnexionException $e) {
            //TODO: page d'erreur de connection
        }
    }

    public function afficher($gagne) {
        //TODO: afficher la place dans le classement
        if($gagne) {
            $this->daoResultats->ajouterVictoire($_SESSION['pseudo']);
        }
        $resultatJoueur = $this->daoResultats->partiesGagneesJoueur($_SESSION['pseudo']);
        $meilleursResultats = $this->daoResultats->statsMeilleursJoueurs();
        $this->vue->resultats($gagne, $resultatJoueur['partieGagnee'], $meilleursResultats);
    }

}