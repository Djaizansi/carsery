<?php

namespace Carsery\Core;

class Model{

	public function __construct(){
        
    }

    /**
     * Fournit des données correspondant à ses attributs pour qu'il assigne les valeurs 
     *  souhaitées à ces derniers
     * @param $data
     */
    public function hydrate($data){
        
        //Parcours de l'ensemble du tableau
        foreach ($data as $key => $value) {

            //Vérifie si la propriéte courante de l'objet courant existe
            if(method_exists($this, $key)){
    
                //On construit le setter
                $setter = 'set'.ucfirst($key);

                //On lui assigne sa valeur courante via $value
                $this->$setter($value);
            }
        }
        
    }

    /*
     * Converti un objet en tableau
     */
    public function __toArray(): array {
        
        return get_object_vars($this);
    }
}

