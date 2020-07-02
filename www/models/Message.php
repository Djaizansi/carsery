<?php
namespace carsery\models;

use carsery\core\DB;
use carsery\core\Helpers;

class Message extends DB{

    protected $id;
    protected $message;
    protected $article_id;

    public function hydrate(array $donnees){
        foreach ($donnees as $key => $value){
        // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.str_replace('_', '', ucwords($key, '_'));
        // Si le setter correspondant existe bien.
            if (method_exists($this, $method)){
            // On appelle le setter.
            $this->$method($value);
            }
        }
        return $this;
    }
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->article_id;
    }

    /**
     * @param mixed $article_id
     */
    public function setArticleId($article_id)
    {
        $this->article_id = $article_id;
    }

}