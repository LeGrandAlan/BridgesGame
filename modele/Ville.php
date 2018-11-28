<?php


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
        $this->villesLiees=null;
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
