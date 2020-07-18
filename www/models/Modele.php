<?php

namespace carsery\models;

use carsery\models\Marque;
use carsery\models\Model;


class Modele extends Model {

    protected $id ;
    protected $nomModele ;
    protected $marque;
	
	public function __construct($nomModele = null ,$marque = null){
		
		$this->nomModele = $nomModele;
		$this->marque = $marque;
	}

    public function initRelation(): array { //Initialisation de la relation entre Modele et Marque
        return [
            'marque' => Marque::class
        ];
    }

    
    /**
     * 
     * @param type $id
     */
    public function setId(int $id): self
    {
        $this->id=$id;
        return $this;
    }
    
    /**
     * 
     * @param type $nomModele
     */
    public function setNomModele($nomModele){

        
        if(is_string($nomModele)){

            
            $this->nomModele=ucwords(strtolower(trim($nomModele)));
        
            
        }
        
        
    }

    /**
     * 
     * @param \carsery\models\Marque $marque
     */
    function setMarque(Marque $marque) : Modele {
     
        $this->marque = $marque;
	return $this ;
 
    }

    /**
     * 
     * @return type
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * 
     * @return type
     */
    function getNomModele() {
        return $this->nomModele;
    }
    
    /**
     * 
     * @return type
     */
    function getMarque() : Marque{
     
        return $this->marque;
    }

}

