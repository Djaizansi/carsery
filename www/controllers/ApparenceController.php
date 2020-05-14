<?php 

namespace carsery\controllers;

use carsery\core\Session;
use carsery\core\View;

class ApparenceController {

    public function apparenceAction()
    {
        if(Session::estConnecte()){
            $myView = new View("apparence");
            $theme = "Par défaut";
            $myView->assign("theme", $theme);
        }else {
            include_once "./error/notConnected.php";
        }

    }

    public function changementAction()
    {
        $myView = new View("apparence");
        
        if(isset($_POST['formtheme'])){
            if(isset($_POST['theme2'])){
                $theme2 = $_POST['theme2'];
                $theme = "Thème 2";
                $myView->assign("theme", $theme);
            } else {
                $theme = "Le thème n'a pas pu être chargé correctement";
                $myView->assign("theme", $theme);
            }
        } else {
            $theme = "Le thème n'a pas pu être appliqué correctement";
            $myView->assign("theme", $theme);
        }
    }
}