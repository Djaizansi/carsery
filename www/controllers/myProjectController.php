<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Session;
use carsery\core\View;
use carsery\Managers\PageManager;

class myProjectController {

    public function viewAction()
    {
        $uri = $_SERVER['REQUEST_URI'];
        new Session();
        $data = explode('/',$uri)[2];
        $notiret = str_replace('-','',strtolower($data));
        $pageManager = new PageManager();
        $found = $pageManager->findByUri($uri);
        $public = $found->getPublie();
        if($public == 0 && Session::estConnecte()){
            $myView = new View($notiret,'template1');
        }elseif($public == 1) {
            $myView = new View($notiret,'template1');
        }else {
            throw new RouteException("Il faut être connecter pour modifier la page");
        }
    }
}
