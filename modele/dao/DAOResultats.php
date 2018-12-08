<?php


class DAOResultats {

    private $connexion;

    /**
     * DAOResultats constructor.
     * @throws ConnexionException
     */
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

    /**
     * Méthode qui ferme la connection.
     */
    public function deconnexion(){
        $this->connexion=null;
    }

    /**
     * Méthode qui ajoute une partie en base de donnée
     * @param $pseudoJoueur string pseudo du jour ayant joué la partie
     * @param $gagne bool true si la partie est gagnée, faux sinon
     */
    public function ajouterPartie($pseudoJoueur, $gagne) {
        $statement = $this->connexion->prepare("insert into parties (pseudo, partieGagnee) values (?, ?);");
        $statement->bindParam(1, $pseudoJoueur);
        $statement->bindParam(2, $gagne);
        $statement->execute();
    }

    /**
     * Méthode qui va chercher le nombre de partie qu'un utilisateur a gagnées
     * @param $pseudoJoueur string pseudo du joueur
     * @return int nombre de parties gagnées
     */
    public function partiesGagneesJoueur($pseudoJoueur) {
        $statement = $this->connexion->prepare("select count(*) as partiesGagnee from parties where pseudo=? and partieGagnee = '1';");
        $statement->bindParam(1, $pseudoJoueur);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    /**
     * Méthode qui va chercher le nombre de partie qu'un utilisateur à faites
     * @param $pseudoJoueur string pseudo du joueur
     * @return int nombre de parties jouées
     */
    public function partiesJoueesJoueur($pseudoJoueur) {
        $statement = $this->connexion->prepare("select count(*) as partiesJouees from parties where pseudo=?;");
        $statement->bindParam(1, $pseudoJoueur);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    /**
     * Méthode qui indique les 3 premiers joueurs en fonction de leur nombre de victoire
     * @return array
     */
    public function statsMeilleursJoueurs() {
        $statement = $this->connexion->prepare("select pseudo, count(*) as partiesGagnee from parties where partieGagnee = '1' group by pseudo asc limit 3;");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Méthode qui indique les 3 premiers joueurs en fonction de leur ration (parties gagnées / parties jouées)
     * @return array
     */
    public function ratioMeilleursJoueurs() {
        $statement = $this->connexion->prepare("select pseudo, sum(partieGagnee)/count(pseudo) as ratio_victoire from parties group by pseudo order by 2 desc limit 3;");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}