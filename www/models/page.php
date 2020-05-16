<?php

namespace carsery\models;

use carsery\core\DB;
use carsery\core\Helpers;


class page extends DB
{
    protected $id;
    protected $titre;
    protected $auteur;
    protected $date;
    protected $publie;
    protected $action;

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

    /**
     * Get the value of action
     */ 
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set the value of action
     *
     * @return  self
     */ 
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public static function getPageForm(){
        return [
                    "config"=>[
                            "method"=>"POST",
                            "action"=>Helpers::getUrl("Page", "addPage"),
                            "class"=>"box",
                            "id"=>"formAddPage",
                            "submit"=>"Créer"
                    ],

                    "fields"=>[
                        "titre"=>[
                            "type"=>"text",
                            "placeholder"=>"Entrez un titre",
                            /* "class"=>"form-control form-control-user", */
                            "id"=>"id_titre",
                            "required"=>true,
                            "errorMsg"=>"Votre email n'est pas valide"
                        ],

                        "action"=>[
                            "type"=>"text",
                            "placeholder"=>"Quel est votre action",
                            /* "class"=>"form-control form-control-user", */
                            "id"=>"id_action",
                            "required"=>true,
                            "errorMsg"=>"Votre email n'est pas valide"
                        ],
                    ]
                ];
    }
}