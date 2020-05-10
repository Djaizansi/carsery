<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;

class VoitureController {
    public function voitureAction() 
    {   
        if(Session::estConnecte()){
            $myView = new View("voiture");
        }else {
            include_once "./error/notConnected.php";
        }
    }
}