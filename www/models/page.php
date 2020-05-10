<?php

namespace carsery\models;

use carsery\core\DB;


class page extends DB
{
    protected $id;
    protected $titre;
    protected $auteur;
    protected $date;
    protected $publie;

    public function __construct()
    {
        parent::__construct();
    }

    public function hydrate(array $donnees){
        foreach ($donnees as $key => $value){
        // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
        // Si le setter correspondant existe bien.
            if (method_exists($this, $method)){
            // On appelle le setter.
            $this->$method($value);
            }
        }
        return $this;
    }

    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of titre
     */ 
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of auteur
     */ 
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set the value of auteur
     *
     * @return  self
     */ 
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of publie
     */ 
    public function getPublie()
    {
        return $this->publie;
    }

    /**
     * Set the value of publie
     *
     * @return  self
     */ 
    public function setPublie($publie)
    {
        $this->publie = $publie;

        return $this;
    }
}