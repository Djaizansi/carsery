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
        $myTheme1 = "Par défaut";
        $myTheme2 = "Thème 2";
        $myTheme3 = "Thème 3";
        $myTheme4 = "Thème 4";
        $myView->assign("myTheme1", $myTheme1);
    }
}