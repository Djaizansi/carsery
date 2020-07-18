<?php


namespace carsery\models;

use carsery\models\Model;

class Marque extends Model{

    protected $id;
    protected $nomMarque ;

    public function __construct($name = null){
	
	$this->nomMarque = $name;
    }	

    public function initRelation(): array {
        return [
           
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
     * @param type $nomMarque
     */
    public function setNomMarque($nomMarque){

        if(is_string($nomMarque)){

            $this->nomMarque=ucwords(strtolower(trim($nomMarque)));
        }
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
    public function getNomMarque() {
        return $this->nomMarque;
    }


}

?>

