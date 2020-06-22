<?php

namespace carsery\models;

class User extends Model
{
    protected $id;
    protected $lastname;
    protected $firstname;
    protected $email;
    protected $pwd;
    protected $status;
    protected $token;

    public function initRelation(): array {
        return [
        
        ];
    }


    public function setId($id)
    {
        $this->id=$id;
    }
    public function setFirstname($firstname)
    {
        $this->firstname=ucwords(strtolower(trim($firstname)));
    }
    public function setLastname($lastname)
    {
        $this->lastname=strtoupper(trim($lastname));
    }
    public function setEmail($email)
    {
        $this->email=strtolower(trim($email));
    }
    public function setPwd($pwd)
    {
        $this->pwd=$pwd;
    }
    public function setStatus($status)
    {
        $this->status=$status;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPwd()
    {
        return $this->pwd;
    }
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}
