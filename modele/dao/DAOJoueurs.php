<?php
require_once PATH_DAO.'/Exception/DaoException.php';
require_once PATH_DAO.'/Exception/ConnexionException.php';
require_once PATH_DAO.'/Exception/TableAccesException.php';

/**
 * Class DAOJoueurs
 */
Class DAOJoueurs {

    private $connexion;

    /**
     * DAOJoueurs constructor.
     * @throws ConnexionException
     */
    public function __construct(){
        try{
            $chaine="mysql:host=".HOST.";dbname=".BD;
            $this->connexion = new PDO($chaine,LOGIN,PASSWORD);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            $exception = new ConnexionException("Problème de connexion à la base");
            throw $exception;
        }
    }

    /**
     * Méthode qui ferme la connection
     */
    public function deconnexion(){
        $this->connexion=null;
    }

    /**
     * Méthode qui indique si le pseudo existe dans la base de donnée
     * @param $pseudo string pseudo de l'utilisateur à tester
     * @return bool vrai si le pseudo existe, faux sinon
     * @throws TableAccesException Si erreur de connection à la base de données
     */
    public function existepseudo($pseudo){
        try{
            $statement = $this->connexion->prepare("select pseudo from joueurs where pseudo=?;");
            $pseudoParam = $pseudo;
            $statement->bindParam(1, $pseudoParam);
            $statement->execute();
            $result=$statement->fetch(PDO::FETCH_ASSOC);

            if ($result["pseudo"]!=NUll){
                return true;
            }
            else{
                return false;
            }
        }
        catch(PDOException $e){
            $this->deconnexion();
            throw new TableAccesException("Problème avec la table joueurs");
        }
    }

    /**
     * Méthode qui récupère le mot de passe de l'utilisateur
     * @param $pseudo string pseudo de l'utilisateur à tester
     * @return string mot de passe de l'utilisateur
     * @throws TableAccesException Si erreur de connection à la base de données
     */
    public function getmotdepasse($pseudo){
        try{
            $statement = $this->connexion->prepare("select motDePasse from joueurs where pseudo=?;");
            $pseudoParam = $pseudo;
            $statement->bindParam(1, $pseudoParam);
            $statement->execute();
            $result=$statement->fetch(PDO::FETCH_ASSOC);

            return $result["motDePasse"];
        }
        catch(PDOException $e){
            $this->deconnexion();
            throw new TableAccesException("problème avec la table joueurs");
        }
    }


}

