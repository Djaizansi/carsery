<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;

class ForumController {
    public function forumAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("forum");
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}