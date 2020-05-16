<?php

namespace Carsery\Models;

require('core/DB.php');

use Carsery\Core\DB ;

class modeles extends DB {

    protected $id ;
    protected $nomModele ;
	protected $marque_id ;

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
    
	public function setNomModele($nomModele){

		if(is_string($nomModele)){

			$this->nomModele=ucwords(strtolower(trim($nomModele)));
		}
        
		
    }
	
	public function setIdMarque($marque_id){
        
		$this->marque_id=(int)$marque_id;
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
