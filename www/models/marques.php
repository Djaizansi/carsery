<?php

namespace Carsery\Models;

use Carsery\Core\Model ;

class marques extends Model{

    protected $id;
    protected $nomMarque ;
		
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
     * @param type $nomMarque
     */
	public function setNomMarque($nomMarque){

        if(is_string($nomMarque)){

            $this->nomMarque=ucwords(strtolower(trim($nomMarque)));
        }
    }

}

?>
