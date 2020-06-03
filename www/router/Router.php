<?php

namespace carsery\router;

use carsery\core\Exceptions\RouteException;
use carsery\Managers\PageManager;
use carsery\controllers\myProjectController;

class Router {

    public function __construct(){
        $this->routing();
    }

    public function routing(){
        $uri = $_SERVER["REQUEST_URI"];
        $yaml = yaml_parse_file("router/routes.yml");
        $uri = explode("?",$uri)[0];
        $pageManager = new PageManager();
        $found = $pageManager->findByUri($uri);
        if($found){
            $controller = new myProjectController();
            $controller->viewAction();
        }elseif(!empty($yaml[$uri])) {

            $c =  'carsery\\controllers\\'.$yaml[$uri]["controller"]."Controller";
            $d = $yaml[$uri]["controller"]."Controller";
            $a =  $yaml[$uri]["action"]."Action";

            $pathController = "controllers/".$d.".php";
            if (file_exists($pathController)) {
                include $pathController;
                //Vérifier que la class existe et si ce n'est pas le cas faites un die("La class controller n'existe pas")
                if (class_exists($c)) {
                    $controller = new $c();
                    //Vérifier que la méthode existe et si ce n'est pas le cas faites un die("L'action' n'existe pas")
                    if (method_exists($controller, $a)) {
                        //EXEMPLE :
                        //$controller est une instance de la class UserController
                        //$a = userAction est une méthode de la class UserController
                        $controller->$a();
                    } else {
                        throw new RouteException("L'action n'a pas été trouver");
                    }
                } else {
                    throw new RouteException("La classe controller n'a pas été trouver.");
                }
            } else {
                throw new RouteException("Le fichier controlleur n'existe pas");
            }
        } else {
            throw new RouteException("La page n'existe pas");
        }
    }
}