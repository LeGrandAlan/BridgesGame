<?php


class DAOResultats {

    private $connexion;

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

    public function ajouterVictoire($pseudoJoueur) {
        $statement = $this->connexion->prepare("update parties set partieGagnee = partieGagnee + 1  where pseudo=?;");
        $statement->bindParam(1, $pseudoJoueur);
        $statement->execute();
    }

    public function partiesGagneesJoueur($pseudoJoueur) {
        $statement = $this->connexion->prepare("select partieGagnee from parties where pseudo=?;");
        $statement->bindParam(1, $pseudoJoueur);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function statsMeilleursJoueurs() {
        //TODO: faire le ratio /!\ il faudra changer la structure de la base de données
        $statement = $this->connexion->prepare("select pseudo, partieGagnee from parties order by partieGagnee desc limit 3;");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}