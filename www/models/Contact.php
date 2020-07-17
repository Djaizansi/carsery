<?php

namespace carsery\models;

class Contact extends Model
{
    protected $id;
    protected $adresse;
    protected $nom;

    public function initRelation(): array {
        return [
        
        ];
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
    }

    /**
     * Get the value of Adresse
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of Adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * Get the value of Nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of Nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
}