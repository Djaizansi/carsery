<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;

class ForumController {
    public function forumAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("forum");
        }else {
            include_once "./error/notConnected.php";
        }
    }
}