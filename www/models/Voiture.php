<?php 

namespace carsery\models;


use carsery\models\Model;
use carsery\models\Marque;
use carsery\models\Modele;

class Voiture extends Model{
    
    protected $id;
    protected $immatriculation;
    protected $anneeCreation;
    protected $compteur ;
    protected $situation; //Neuf ou Occassion
    protected $etat ; //Disponible , Loue, immobilisé
    protected $marque;
    protected $modele ;

    public function __construct($imma = null, $annee = null, $km = null, 
	$situation = null, $etat = null ,$marque = null, $modele = null){

	$this->immatriculation = $imma;
	$this->anneeCreation = $annee;
	$this->compteur = $km;
	$this->situation = $situation;
	$this->etat = $etat ;
	$this->marque = $marque;
	$this->modele = $modele;
    }

    /**
     *Initialisation des relations liées avec l'objet courant
     */
    public function initRelation(): array {
        return [
            'marque' => Marque::class,
	    'modele' => Modele::class
        ];
    }
   
    public function setId(int $id): self
    {
        $this->id=$id;
        return $this;
    }


    /**
     * 
     * @param type $immatriculation
     */
    public function setImmatriculation($immatriculation){
        
        if(is_string($immatriculation)){
            
            $this->immatriculation=strtoupper(trim($immatriculation));
        }  
    }
    
    /**
     * 
     * @param type $anneeCreation
     */
    public function setAnneeCreation($anneeCreation){
        
    $this->anneeCreation= (int)$anneeCreation;
    }
    
    /**
     * 
     * @param type $compteur
     */
    public function setCompteur($compteur){
        
    $this->compteur= (int)$compteur;
    }
    
    /**
     * 
     * @param type $situation
     */
    public function setSituation($situation){
        
    if(is_string($situation)){
            
            $this->situation=ucwords(strtolower(trim($situation)));
        }
    }
	
	/**
     * 
     * @param type $etat
     */
    public function setEtat($etat){
        
        if(is_string($etat)){
            
            $this->etat=ucwords(strtolower(trim($etat)));
        }
    }

    
    /**
     * 
     * @param \carsery\models\Marque $marque
     */
    public function setMarque(Marque $marque) : Voiture{
        $this->marque = $marque;
	return $this ;
    }

    /**
     * 
     * @param \carsery\models\Modele $modele
     * @return $this
     */
    public function setModele(Modele $modele) : Voiture {
        $this->modele = $modele;
	return $this;
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
    public function getImmatriculation() {
        return $this->immatriculation;
    }

    /**
     * 
     * @return type
     */
    public function getAnneeCreation() {
        return $this->anneeCreation;
    }

    /**
     * 
     * @return type
     */
    public function getCompteur() {
        return $this->compteur;
    }

    /**
     * 
     * @return type
     */
    public function getSituation() {
        return $this->situation;
    }
	
	/**
     * 
     * @return type
     */
    public function getEtat() {
        return $this->etat;
    }

    /**
     * 
     * @return type
     */
    public function getMarque() : Marque {
        return $this->marque;
    }

    /**
     * 
     * @return type
     */
    public function getModele() : Modele {
        return $this->modele;
    }

}

