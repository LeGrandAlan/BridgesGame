<?php 

require_once PATH_MODELE.'/dao.php';
require_once PATH_VUE.'/login.php';


class Authentification{

	private $dao;
	private $vue;

	public function __construct() {
		$this->dao = new Dao();
		$this->vue = new Vuelogin();
	}


	public function accueil(){
		$this->vue->login();
	}
	public function selogin($pseudo,$motdepasse){

		if ($this->dao->existepseudo($pseudo)){

			$mdpscrype = $this->dao->getmotdepasse($pseudo);

			if (crypt($motdepasse, $mdpscrype)== $mdpscrype){
				                        
				$_SESSION['pseudo']= $pseudo;
				header('Location: index.php');

			} else {
				echo "mavais mot de passe";
				$this->accueil();
			}

		} else {
			echo "mauvais pseudo";
			$this->accueil();
		}

	}
}