<?php 

namespace Carsery\Models;

require('core/DB.php');

use Carsery\Core\DB ;

class vehicules extends DB {


    public function __construct(){
        
        parent::__construct();
    }

    /**
     * 
     * @param type $id
     */
    public function setId($id){
        
        $id = (int) $id;
        
        if($id > 0){
            
          $this->id=$id;
       }  
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
     * @param type $marque_id
     */
    public function setIdMarque($marque_id){
    
        $this->marque_id= (int)$marque_id;
    }
	
    /**
     * 
     * @param type $modele_id
     */
    public function setIdModele($modele_id){
        
        $this->modele_id= (int)$modele_id;
        
    }

    /**
     * Fournit des données correspondant à ses attributs pour qu'il assigne les valeurs 
     *  souhaitées à ces derniers
     * @param $data
     */
    public function hydrate($data){
        
        //Parcours de l'ensemble du tableau
        foreach ($data as $key => $value) {

            //Vérifie si la propriéte courante de l'objet courant existe
            if(property_exists($this, $key)){
    
                //On construit le setter
                $setter = 'set'.ucfirst($key);

                //On lui assigne sa valeur courante via $value
                $this->$setter($value);
            }
        }
        
    }
}
