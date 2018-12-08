<?php

require_once PATH_DAO . '/DAOJoueurs.php';
require_once PATH_VUE . '/VueLogin.php';

/**
 * Class ControlleurAuthentification
 * Controlleur qui gère l'authentification des utilisateurs
 */
class ControlleurAuthentification{

    private $dao;
    private $vue;

    /**
     * Constructeur de ControlleurAuthentification.
     */
    public function __construct() {
        try {
            $this->dao = new DAOJoueurs();
        } catch (ConnexionException $e) {
            //TODO: page d'erreur de connection
        }
        $this->vue = new Vuelogin();
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
                    echo "Mauvaise combinaison mot de passe/pseudo.";
                    $this->accueil();
                }
            } else {
                echo "Mauvaise combinaison mot de passe/pseudo.";
                $this->accueil();
            }
        } catch (TableAccesException $e) {
            //TODO: gérer ça (affichage de la page d'erreur)
        }
    }
}