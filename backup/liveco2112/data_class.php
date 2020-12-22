<?php
class data {

    public $prenom=[];
    public $nom;
    public $age;

public function __construct($a,$b,$c)
{
 $this->prenom = $a;
 $this->nom = $b;
 $this->age = $c;

}
public function affiche($a,$b,$c)
{
    echo "<h1> $a - $b - $c </h1>";
   
}

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }
}

?>