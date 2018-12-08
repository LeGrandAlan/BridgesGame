<?php
session_start();
require_once 'ControlleurAuthentification.php';
require_once 'ControlleurJeu.php';
require_once 'ControlleurResultats.php';

/**
 * Class Routeur
 */
class Routeur {

    private $controlleurAuthentification;
    private $controlleurJeu;
    private $controlleurResultat;

    /**
     * Routeur constructor.
     */
    public function __construct() {
        $this->controlleurAuthentification = new ControlleurAuthentification();
        $this->controlleurJeu = new ControlleurJeu();
        $this->controlleurResultat = new ControlleurResultats();
    }

    /**
     * Méthode qui gère les requêtes en appelant les méthodes/vues
     */
    public function routerRequete() {
        if(isset($_SESSION["pseudo"])) {
            if (isset($_GET['x']) && isset($_GET['y'])) {
                $this->controlleurJeu->jouer($_GET['x'], $_GET['y']);
            } else if (isset($_SESSION['gagne'])) {
                $gagne = $_SESSION['gagne'];
                unset($_SESSION['gagne']);
                $this->controlleurResultat->afficher($gagne);
            } else if (isset($_GET['abandonner'])) {
                $this->controlleurResultat->afficher($gagne=false);
            } else if (isset($_GET['resultat'])) {
                $this->controlleurResultat->afficher();
            } else if (isset($_GET['annulercoup'])) {
                $this->controlleurJeu->annulerPrecedent();
            } else {
                $this->controlleurJeu->init_jeu();
            }
        } else {
            if(isset($_POST["seconnecter"]) && !empty($_POST["pseudo"]) && !empty($_POST["motdepasse"])) {
                $this->controlleurAuthentification->selogin($_POST["pseudo"],$_POST["motdepasse"]);
            }
            else {
                $this->controlleurAuthentification->accueil();
            }
        }
    }


}
