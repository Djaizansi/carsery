<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;

class MailController {
    public function mailAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("mail");
        }else {
            include_once "./error/notConnected.php";
        }
    }
}