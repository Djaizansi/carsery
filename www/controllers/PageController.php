<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;
use carsery\models\page;

class PageController {
    public function pageAction() 
    {
        if(Session::estConnecte()){
            $page = new page();
            $myView = new View("page");
            $myView->assign('page',$page);

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