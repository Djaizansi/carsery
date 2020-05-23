<?php

namespace Carsery\Models;

use Carsery\Core\Model ;

class modeles extends Model {

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

}
