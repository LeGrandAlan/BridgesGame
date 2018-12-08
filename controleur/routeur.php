<?php
session_start();
require_once 'authentification.php';
require_once 'contrjeu.php';
require_once 'ContrResultats.php';

class Routeur {

    private $authentification;
    private $jeu;
    private $contrResultats;

    public function __construct() {
        $this->authentification = new Authentification();
        $this->jeu = new Contrjeu();
        $this->contrResultats = new ContrResultats();
    }

    public function routerRequete() {
        if(isset($_SESSION["pseudo"])) {
            if (isset($_GET['x']) && isset($_GET['y'])) {
                $this->jeu->jouer($_GET['x'], $_GET['y']);
            } else if (isset($_SESSION['gagne'])) {
                $gagne = $_SESSION['gagne'];
                unset($_SESSION['gagne']);
                $this->contrResultats->afficher($gagne);
            } else if (isset($_GET['annulercoup'])) {
                $this->jeu->annulerPrecedent();
            } else if (isset($_GET['abandonner'])) {
                $this->jeu->abandonner(); //TODO: à faire
            } else {
                $this->jeu->init_jeu();
            }
        } else {
            if(isset($_POST["seconnecter"]) && !empty($_POST["pseudo"]) && !empty($_POST["motdepasse"])) {
                $this->authentification->selogin($_POST["pseudo"],$_POST["motdepasse"]);
            }
            else {
                $this->authentification->accueil();
            }
        }
    }


}
