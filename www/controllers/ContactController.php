<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;

class ContactController {
    public function contactAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("contact");
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}