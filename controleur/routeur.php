<?php 

require_once 'authentification.php';
require_once 'contrjeu.php';

class Routeur {
	
	private $authentification;
	private $jeu;

	public function __construct() {
		$this->authentification = new Authentification();
		$this->jeu = new Contrjeu();
	}

	public function routerRequete() {

		if(isset($_SESSION["pseudo"])){
			$this->jeu->jouer();
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




?>