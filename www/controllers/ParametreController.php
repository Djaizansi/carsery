<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;


class ParametreController {
    public function parametreAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("parametre");
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}