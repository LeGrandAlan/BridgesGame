<?php 

require_once PATH_VUE.'/jeu.php';

class Contrjeu{

	private $vue;

	public function __construct() {
	
		$this->vue = new VueJeu();
	}

	public function jouer(){
		$this->vue->jeu();
	}
}

?>