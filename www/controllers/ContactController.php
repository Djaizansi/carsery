<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;

class ContactController {
    public function contactAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("contact");
        }else {
            include_once "./error/notConnected.php";
        }
    }
}