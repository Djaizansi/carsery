<?php

namespace carsery\models;

class Recuperation extends Model
{
    protected $id;
    protected $mail;
    protected $code;
    protected $confirme;

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

}