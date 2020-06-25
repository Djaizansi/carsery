<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;

class MailController {
    public function mailAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("mail");
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}