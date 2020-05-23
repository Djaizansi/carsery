<?php 

namespace Carsery\Exceptions;

class BDDException extends Exception{

	public function __construct($message, $code = 0){
    
    		parent::__construct($message, $code);
  	}
}
