<?php
require_once PATH_DAO . '/DAOResultats.php';
require_once PATH_VUE . '/VueResultats.php';

/**
 * Class ControlleurResultats
 */
class ControlleurResultats {

    private $daoResultats;
    private $vue;

    /**
     * ControlleurResultats constructor.
     */
    function __construct() {
        try {
            $this->daoResultats = new DAOResultats();
            $this->vue = new VueResultats();
        } catch (ConnexionException $e) {
            //TODO: page d'erreur de connection
        }
    }

    /**
     * Méthode qui récupère les données en base de donnée et qui affche la page de résultat
     * @param $gagne bool|null vrai si l'utilisateur a gagné, faux sinon. Null si la page est simplement demandée (sans partie avant)
     */
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