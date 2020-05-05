<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;

class PanierController {
    public function panierAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("panier");
        }else {
            include_once "./error/notConnected.php";
        }
    }
}