<?php

namespace carsery\models;

class Model
{
    public function __toArray(): array
    {
        return get_object_vars($this);
    }

    /* public function hydrate(array $donnees){
        $className = get_class($this);
        $articleObj = new $className();
        foreach ($donnees as $key => $value){
        // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
        // Si le setter correspondant existe bien.
            if (method_exists($articleObj, $method)){
            // On appelle le setter.
            $articleObj->$method($value);
            }
        }
        return $articleObj;
    } */

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
}