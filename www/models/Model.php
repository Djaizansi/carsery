<?php

namespace carsery\models;

use carsery\core\Exceptions\BDDException;

class Model
{
    public function __toArray(): array
    {
        return get_object_vars($this);
    }

    public function hydrate(array $donnees){
        if(!empty($donnees)){
            foreach ($donnees as $key => $value){
                // On récupère le nom du setter correspondant à l'attribut.
                $method = 'set'.ucfirst($key);
                // Si le setter correspondant existe bien.
                if (method_exists($this, $method)){
                    // On appelle le setter.
                    $this->$method($value);
                }
            }
        }else {
            throw new BDDException('Erreur hydratation');
        }
    

        return $this;
    }
}
