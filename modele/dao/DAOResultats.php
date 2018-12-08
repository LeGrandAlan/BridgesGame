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

    //TODO: COMMENTER TOUT CA
    public function ajouterPartie($pseudoJoueur, $gagne) {
        $statement = $this->connexion->prepare("insert into parties (pseudo, partieGagnee) values (?, ?);");
        $statement->bindParam(1, $pseudoJoueur);
        $statement->bindParam(2, $gagne);
        $statement->execute();
    }

    public function partiesGagneesJoueur($pseudoJoueur) {
        $statement = $this->connexion->prepare("select count(*) as partiesGagnee from parties where pseudo=? and partieGagnee = '1';");
        $statement->bindParam(1, $pseudoJoueur);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public function partiesJoueesJoueur($pseudoJoueur) {
        $statement = $this->connexion->prepare("select count(*) as partiesJouees from parties where pseudo=?;");
        $statement->bindParam(1, $pseudoJoueur);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public function statsMeilleursJoueurs() {
        $statement = $this->connexion->prepare("Select pseudo, count(*) as partiesGagnee from parties where partieGagnee = '1' group by pseudo asc limit 3;");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function ratioMeilleursJoueurs() {
        $statement = $this->connexion->prepare("
            Select p1.pseudo, count(p1.pseudo) / partiesJouees as ratio_victoire
            from parties p1
                left join 
                  (SELECT p2.id, p2.pseudo, count(*) as partiesJouees from parties p2 group by p2.pseudo) p2
                ON p1.id = p2.id
            where p1.partieGagnee = '1' group by p1.pseudo ORDER by 2 desc limit 3;
        ");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}