<?php 

namespace carsery\controllers;

use carsery\core\Session;
use carsery\core\View;

class ApparenceController {
    public function apparenceAction()
    {
        if(Session::estConnecte()){
            $myView = new View("apparence");
        } else {
            include_once "./error/notConnected.php";
        }

        $theme = "Par défaut";
        $myView->assign("theme", $theme);
        
        if(isset($_POST['themeOne'])){
            $theme = "Par défaut";
            $_SESSION['theme'] = $theme;
            $myView->assign("theme", $theme);
        } else if(isset($_POST['themeTwo'])){
            $theme = "Thème 2";
            $_SESSION['theme'] = $theme;
            $myView->assign("theme", $theme);
        } else if(isset($_POST['themeThree'])){
            $theme = "Thème 3";
            $_SESSION['theme'] = $theme;
            $myView->assign("theme", $theme);
        }
    }
}