<?php

class Personnage {
    private $pts_vie;
    private $pts_armure;
    private $pts_attaque;
    private $nom;
    protected $munitions;

    function __construct($nom,$ptsvie,$ptsarmure,$ptsattaque)
    {
        $this->pts_vie = $ptsvie;
        $this->pts_armure = $ptsarmure;
        $this->pts_attaque = $ptsattaque;
        $this->nom = $nom;
    }

    function setPtsVie($pts){
        $this->pts_vie = $pts;
    }

    function getPtsVie(){
        return $this->pts_vie;
    }

    function setPtsArmure($pts){
        $this->pts_armure = $pts;
    }

    function getPtsArmure(){
        return $this->pts_armure;
    }

    function setPtsAttaque($pts){
        $this->pts_attaque = $pts;
    }

    function getPtsAttaque(){
        return $this->pts_attaque;
    }

    function setNom($nom){
        $this->nom = $nom;
    }

    function getNom(){
        return $this->nom;
    }

    function setMunitions($munitions){
        $this->munitions = $munitions;
    }

    function getMunitions(){
        return $this->munitions;
    }

    function isDied(){
        if($this->pts_vie <= 0) return true;
        return false;
    }

    function isAlive(){
        return !$this->isDied();
    }

    function attaque($ennemi){
        $pts_attaque = $ennemi->getPtsAttaque();
        if($this->isAlive()) $this->pts_vie = $this->pts_vie-$pts_attaque;
        if($this->pts_vie < 0) $this->pts_vie = 0;
    }
    
}

class Sniper extends Personnage {
    function __construct($nom){
        $ptsvie = 50;
        $ptsarmure = 0;
        $ptsattaque = 100;
        $this->munitions = 5;
        parent::__construct($nom,$ptsvie,$ptsarmure,$ptsattaque);
    }

    function acheteBalles(){
        $this->munitions+= 5;
    }
}

class Archer extends Personnage {
    function __construct($nom){
        $ptsvie = 100;
        $ptsarmure = 50;
        $ptsattaque = 60;
        $this->munitions = 20;
        parent::__construct($nom,$ptsvie,$ptsarmure,$ptsattaque);
    }

    function acheteFleches(){
        $this->munitions+= 15;
    }
}

$p1 = new Personnage("Arnaud",100,50,10);
$p2 = new Personnage("Thor",100,50,10);
$p1->attaque($p2);

$p1 = new Sniper("Arnaud");
$p2 = new Archer("Thor");
$p1->attaque($p2);

$p1->acheteBalles();
$p2->acheteFleches();


/*$p->setNom("Thor");
$p->setPtsVie(100);
$p->setPtsAttaque(10);
$p->setPtsArmure(50);*/



?>