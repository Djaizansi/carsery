<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;

class VoitureController {
    public function voitureAction() 
    {   
        if(Session::estConnecte()){
            $myView = new View("voiture");
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}