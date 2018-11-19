<?php 
session_start();
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
		    if(isset($_GET['x']) && isset($_GET['y'])){
                $this->jeu->jouer($_GET['x'], $_GET['y']);
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
