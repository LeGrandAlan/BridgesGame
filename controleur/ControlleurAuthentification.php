<?php

require_once PATH_DAO . '/DAOJoueurs.php';
require_once PATH_VUE . '/VueLogin.php';
require_once PATH_VUE . '/erreur/VueErreurConnectionBD.php';

/**
 * Class ControlleurAuthentification
 * Controlleur qui gère l'authentification des utilisateurs
 */
class ControlleurAuthentification{

    private $dao;
    private $vue;
    private $vueErreur;

    /**
     * Constructeur de ControlleurAuthentification.
     */
    public function __construct() {
        try {
            $this->vue = new Vuelogin();
            $this->vueErreur = new VueErreurConnectionBD();
            $this->dao = new DAOJoueurs();
        } catch (ConnexionException $e) {
            $this->vueErreur->afficher();
            die();
        }
    }

    /**
     * Méthode qui affiche la vue pour se connecter
     */
    public function accueil(){
        $this->vue->login();
    }

    /**
     * Méthode qui permet de tester si la combinaison mot de passe/login est bonne
     * @param $pseudo string pseudo à tester
     * @param $motdepasse string mot de passer à tester
     */
    public function selogin($pseudo,$motdepasse){
        try {
            if ($this->dao->existepseudo($pseudo)) {
                $mdpscrype = $this->dao->getmotdepasse($pseudo);

                if (crypt($motdepasse, $mdpscrype) == $mdpscrype) {
                    $_SESSION['pseudo'] = $pseudo;
                    header('Location: index.php');
                } else {
                    $_SESSION['erreur'] = "Mauvaise combinaison mot de passe/pseudo.";
                    $this->accueil();
                }
            } else {
                $_SESSION['erreur'] = "Mauvaise combinaison mot de passe/pseudo.";
                $this->accueil();
            }
        } catch (TableAccesException $e) {
            $this->vueErreur->afficher();
            die();
        }
    }

    public function sedeconnecter() {
        $this->dao->deconnexion();
        if (isset($_SESSION['pseudo'])) {
            unset($_SESSION['pseudo']);
        }
        header('Location: index.php');
    }

}