<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;

class MediaController {
    public function mediaAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("media");
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}