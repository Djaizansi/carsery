<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;

class PanierController {
    public function panierAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("panier");
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}