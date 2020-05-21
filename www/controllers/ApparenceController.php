<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Session;
use carsery\core\View;

class ApparenceController {
    public function apparenceAction()
    {
        if(Session::estConnecte()){
            $myView = new View("apparence");
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}