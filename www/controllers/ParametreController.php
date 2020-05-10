<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;


class ParametreController {
    public function parametreAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("parametre");
        }else {
            include_once "./error/notConnected.php";
        }
    }
}