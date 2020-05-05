<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;

class MediaController {
    public function mediaAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("media");
        }else {
            include_once "./error/notConnected.php";
        }
    }
}