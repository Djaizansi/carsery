<?php 

namespace carsery\controllers;

use carsery\core\Session;
use carsery\core\View;

class ApparenceController {

    public function apparenceAction()
    {
        if(Session::estConnecte()){
            $myView = new View("apparence");
        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function changementAction()
    {
        $myView = new View("apparence");
        $prenom = "Marwane";
        $myView->assign("prenom", $prenom);
    }
}