<?php

namespace Carsery\Models;

require('core/DB.php');

use Carsery\Core\DB ;

class marques extends DB{

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

?>
