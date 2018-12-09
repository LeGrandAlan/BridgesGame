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
            if (isset($_GET['x']) && isset($_GET['y'])) { // quand un utilisateur a selectionné une case
                $this->controlleurJeu->jouer($_GET['x'], $_GET['y']);
            } else if (isset($_SESSION['gagne'])) { // quand l'utilisateur à gagné ou perdu
                $gagne = $_SESSION['gagne'];
                unset($_SESSION['gagne']);
                $this->controlleurResultat->afficher($gagne);
            } else if (isset($_GET['abandonner'])) { // quand l'utilisateur abandonne
                $_SESSION['gagne'] = false;
                header('Location: index.php?resultat');
            } else if (isset($_GET['resultat'])) { // quand la page de résultat est demandée
                $this->controlleurResultat->afficher(false);
            } else if (isset($_GET['annulercoup'])) { // quand l'utilisateur veut annuler le coup précédent
                $this->controlleurJeu->annulerPrecedent();
            } else if (isset($_GET['deconnexion'])) { // quand l'utilisateur veut se déconnecter
                $this->controlleurAuthentification->sedeconnecter();
            } else {
                $this->controlleurJeu->init_jeu();
            }
        } else {
            if (isset($_POST["seconnecter"]) && !empty($_POST["pseudo"]) && !empty($_POST["motdepasse"])) {
                $this->controlleurAuthentification->selogin($_POST["pseudo"], $_POST["motdepasse"]);
            } else if (isset($_GET['inscription'])) { // quand l'utilisateur veut s'inscrire
                $this->controlleurAuthentification->inscription();
            } else if(isset($_POST["inscription"]) && !empty($_POST["pseudo"]) && !empty($_POST["motdepasse"])) {
                $this->controlleurAuthentification->inscriptionJoueur($_POST["pseudo"], $_POST["motdepasse"]);
            } else {
                $this->controlleurAuthentification->accueil();
            }
        }
    }


}
