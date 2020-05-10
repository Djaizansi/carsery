<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;

class PageController {
    public function pageAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("page");
        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function lienAction()
    {
        if(Session::estConnecte()){
            $myView = new View("lien");
        }else {
            include_once "./error/notConnected.php";
        }
    }
}