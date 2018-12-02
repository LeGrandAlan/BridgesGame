<?php
require_once PATH_DAO.'/Exception/DaoException.php';
require_once PATH_DAO.'/Exception/ConnexionException.php';
require_once PATH_DAO.'/Exception/TableAccesException.php';


Class DAOJoueurs {
    public function __construct(){
        try{
            $chaine="mysql:host=".HOST.";dbname=".BD;
            $this->connexion = new PDO($chaine,LOGIN,PASSWORD);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){$exception=new ConnexionException("problème de connexion à la base");
            throw $exception;
        }
    }

    public function deconnexion(){
        $this->connexion=null;
    }

    public function existepseudo($pseudo){

        try{
            $statement = $this->connexion->prepare("select pseudo from joueurs where pseudo=?;");
            $statement->bindParam(1, $pseudoParam);
            $pseudoParam=$pseudo;
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
            throw new TableAccesException("problème avec la table joueurs");
        }
    }

    public function getmotdepasse($pseudo){
        try{

            $statement = $this->connexion->prepare("select motDePasse from joueurs where pseudo=?;");
            $statement->bindParam(1, $pseudoParam);
            $pseudoParam=$pseudo;
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

