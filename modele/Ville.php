<?php

/**
 * Class Ville
 */
class Ville{
    // permet d'identifier de manière unique la ville
    private $id;
    private $nombrePontsMax;
    private $nombrePonts;
    // un tableau associatif qui stocke les villes qui sont reliées à la ville cible et le nombre de ponts qui les
    // relient (ce nombre de ponts doit être <=2)
    private $villesLiees;


    /**
     * Constructeur qui permet de valuer les 2 attributs de la classe
     * @param $id int identifiant unique de la ville
     * @param $nombrePontsMax int nombre de ponts maximum que peut avoir la ville
     * @param $nombrePonts int nombre de ponts actuels qu'a la ville
     */
    function __construct($id, $nombrePontsMax, $nombrePonts){
        $this->id=$id;
        $this->nombrePontsMax=$nombrePontsMax;
        $this->nombrePonts=$nombrePonts;
        $this->villesLiees=[];
    }

    /**
     * Sélecteur qui retourne la valeur de l'attribut id
     * @return int identifiant unique de la ville
     */
    function getId(){
        return $this->id;
    }

    /**
     * Sélecteur qui retourne la valeur de l'attribut nombrePontsMax
     * @return int nombre de ponts maximum que peut avoir la ville
     */
    function getNombrePontsMax(){
        return $this->nombrePontsMax;
    }

    /**
     * Sélecteur qui retourne la valeur de l'attribut nombrePonts
     * @return int nombre de ponts maximum que peut avoir la ville
     */
    function getNombrePonts(){
        return $this->nombrePonts;
    }

    /**
     * Modifieur qui permet de valuer l'attribut nombrePonts
     * @param $nb int nombre de ponts à mettre
     */
    function setNombrePonts($nb){
        $this->nombrePonts=$nb;
    }

    //il faut ici implémenter les méthodes qui permettent de lier des villes entre elles, ...

    /**
     * Méthode qui ajoute la ville en paramètre dans les villes liées à celle ci
     * @param $ville Ville ville à lier à cette ville
     */
    public function ajouterVilleLiee($ville) {
        if(!$this->estLieeAvec($ville)) {
            $this->villesLiees[sizeof($this->villesLiees)] = $ville;
        }
    }

    /**
     * Méthode qui supprimer la ville en paramètre, aux villes liées à celle ci
     * @param $ville Ville ville à supprimer des villes liées
     * @return bool vrai si la ville est supprimé, faux sinon
     */
    public function supprimerVilleLiee($ville) {
        for ($i = 0; $i < sizeof($this->villesLiees); $i++) {
            if ($this->villesLiees[$i]->equals($ville)) {
                unset($this->villesLiees[$i]);
                $this->villesLiees = array_values($this->villesLiees); //on réindex pour que les villes liées soient à des index qui se suivent
                return true;
            }
        }
        return false;
    }

    //todo: commenter
    public function getVillesLiees() {
        return $this->villesLiees;
    }

    /**
     * Méthode qui indique si la ville en paramètre est liée avec celle ci
     * @param $ville Ville ville à tester avec celle ci
     * @return bool vrai si elle sont liées, faux sinon
     */
    public function estLieeAvec($ville) {
        for ($i = 0; $i < sizeof($this->villesLiees); $i++) {
            if ($this->villesLiees[$i]->equals($ville)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retourne une chaine de caractère qui identifie uniquement la ville (id)
     * @return string
     */
    public function __toString() {
        return 'ID:' . $this->id;
    }

    /**
     * Indique si deux villes sont égales en fonction de leur id
     * @param $ville Ville ville à comparer avec celle là
     * @return bool vrai si les deux villes sont égales, faux sinon
     */
    public function equals($ville) {
        $equals = false;
        if($this->id == $ville->id) {
            $equals = true;
        }
        return $equals;
    }

    /**
     * Compare les deux villes en fonction de leur id
     * @param $ville Ville ville à comparer avec celle là
     * @return int 0 si les villes sont égales, 1 si cette ville a un id plus grand, -1 sinon
     */
    public function compareTo($ville){
        if($this->equals($ville)) return 0;

        if($this->id > $ville->id){
            return 1;
        }
        return -1;
    }

}
