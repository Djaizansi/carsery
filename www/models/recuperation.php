<?php

namespace carsery\models;

use carsery\core\DB;
use carsery\core\Helpers;


class recuperation extends DB
{
    protected $id;
    protected $mail;
    protected $code;
    protected $confirme;

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
     * Get the value of mail
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of confirme
     */ 
    public function getConfirme()
    {
        return $this->confirme;
    }

    /**
     * Set the value of confirme
     *
     * @return  self
     */ 
    public function setConfirme($confirme)
    {
        $this->confirme = $confirme;

        return $this;
    }

    public static function getCodeForm(){
        return [
            "config"=>[
                    "method"=>"POST",
                    "action"=>helpers::getUrl("user", "forget"),
                    "class"=>"user",
                    "id"=>"formCodeRecup",
                    "submit"=>"Valider"
            ],

            "fields"=>[
                "code"=>[
                    "type"=>"text",
                    "placeholder"=>"Code de vérification",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Veuillez entrez votre code de confirmation"
                ]
            ]
        ];
    }

    public static function getPwdForm(){
        return [
            "config"=>[
                    "method"=>"POST",
                    "action"=>helpers::getUrl("user", "forget"),
                    "class"=>"user",
                    "id"=>"formPwdChange",
                    "submit"=>"Valider"
            ],

            "fields"=>[
                "pwd"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Votre mot de passe doit être compris entre 6 et 16 caractères 
                    avec une Majuscule et Minuscule"
                ],
                "pwdConfirm"=>[
                    "type"=>"password",
                    "placeholder"=>"Confirmation",
                    "class"=>"form-control form-control-user",
                    "id"=>"idPwdConfirm",
                    "required"=>true,
                    "confirmWiths"=>"pwd",
                    "errorMsg"=>"Votre mot de passe de confirmation ne correspond pas"
                ]
            ]
        ];
    }
}