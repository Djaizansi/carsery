<?php

namespace carsery\models;
use carsery\models\Model;

class Piece extends Model{
    
    protected $id;
    protected $nomPiece;
    protected $description;
    protected $prix;
    protected $reference;
    protected $stock;

    public function __construct($nomPiece = null, $description = null, $prix = null, $reference = null, $stock = null){

	$this->nomPiece = $nomPiece;
	$this->description = $description;
	$this->prix = $prix;
	$this->reference = $reference;
	$this->stock = $stock ;
    }

    public function initRelation(): array {
        return [
           
        ];
    }
    
    /**
     * 
     * @return type
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * 
     * @return type
     */
    public function getNomPiece() {
        return $this->nomPiece;
    }

    /**
     * 
     * @return type
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * 
     * @return type
     */
    public function getPrix() {
        return $this->prix;
    }
    
    /**
     * 
     * @return type
     */
    public function getStock() {
        return $this->stock;
    }

    /**
     * 
     * @return type
     */
    public function getReference() {
        return $this->reference;
    }
    
    /**
     * 
     * @param type $id
     * @return $this
     */
    public function setId(int $id) {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @param type $nomPiece
     * @return $this
     */
    public function setNomPiece($nomPiece) {

	if(is_string($nomPiece)){
        
	   $this->nomPiece=trim($nomPiece);
	}
        return $this;
    }

    /**
     * 
     * @param type $description
     * @return $this
     */
    public function setDescription($description) {

	if(is_string($description)){

	  $this->description=trim($description);
	}

        return $this;
    }

    /**
     * 
     * @param type $prix
     * @return $this
     */
    public function setPrix($prix) {

	$this->prix = (float)$prix;

        return $this;
    }

    /**
     * 
     * @param type $stock
     * @return $this
     */
    public function setStock($stock) {

	$this->stock = (int)$stock;
	return $this;
    }

    /**
     * 
     * @param type $reference
     * @return $this
     */
    public function setReference($reference) {

	if(is_string($reference)){

	  $this->reference=strtoupper(trim($reference));
	}

        return $this;
    }
}

