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

    public function afficher($gagne=null) {
        //TODO: afficher la place dans le classement
        if(isset($gagne)) {
            $this->daoResultats->ajouterPartie($_SESSION['pseudo'], $gagne);
        }
        $partiesGagneesJoueur = $this->daoResultats->partiesGagneesJoueur($_SESSION['pseudo']);
        $partiesJoueesJoueur = $this->daoResultats->partiesJoueesJoueur($_SESSION['pseudo']);
        $meilleursResultats = $this->daoResultats->statsMeilleursJoueurs();
        $ratios = $this->daoResultats->ratioMeilleursJoueurs();
        $this->vue->resultats($gagne, $partiesGagneesJoueur['partiesGagnee'], $partiesJoueesJoueur['partiesJouees'], $meilleursResultats, $ratios);
    }

}