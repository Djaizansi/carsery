<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\Managers\PageManager;

class myProjectController {

    public function viewAction()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $data = explode('/',$uri)[2];
        /*  $regex = '#^[A-Za-z0-9\-]+$#';
        if(preg_match($regex, $data)){
            $pageManager = new PageManager(); */
            /* $found = $pageManager->findByTitre($data) */;
            $notiret = str_replace('-','',strtolower($data));
            /* $uriFound = '/myproject'.$found->getUri(); */

            /* if($uri == $uriFound){ */
                $myView = new View($notiret,'front');
            /* } */
        }
    }
/* } */
