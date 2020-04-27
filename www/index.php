<?php

function myAutoloader($class)
{
    if (file_exists("core/".$class.".class.php")) {
        include "core/".$class.".class.php";
    } elseif (file_exists("models/".$class.".model.php")) {
        include "models/".$class.".model.php";
    }
}

/* function myAutoloader($class)
{
$class = str_replace('App', '', $class);

$class = str_replace('\\', '/', $class);

if($class[0] == '/') {
include substr($class.'.php', 1);
} else {
include $class.'.php';
}
} */


spl_autoload_register("myAutoloader");

new ConstantLoader();
//http://localhost/user/add -> $c = user et $a add
//http://localhost/user -> $c = user et $a default
//http://localhost/ -> $c = default et $a default

$uri = $_SERVER["REQUEST_URI"];


$yaml= yaml_parse_file("routes.yml");

if (!empty($yaml[$uri])) {
    $c =  $yaml[$uri]["controller"]."Controller";
    $a =  $yaml[$uri]["action"]."Action";

    $pathController = "controllers/".$c.".class.php";

    if (file_exists($pathController)) {
        include $pathController;
        //Vérifier que la class existe et si ce n'est pas le cas faites un die("La class controller n'existe pas")
        if (class_exists($c)) {
            $controller = new $c();

            //Vérifier que la méthode existeet si ce n'est pas le cas faites un die("L'action' n'existe pas")
            if (method_exists($controller, $a)) {

                //EXEMPLE :
                //$controller est une instance de la class UserController
                //$a = userAction est une méthode de la class UserController
                $controller->$a();
            } else {
                include_once "error/actionNotFound.php";
            }
        } else {
            include_once "error/classControllerNotFound.php";
        }
    } else {
        include_once "error/controllerNotFound.php";
    }
} else {
    include_once "error/404.php";
}
//UTILISER LE FICHIER ROUTES.YML



// $c -> UserController = Class
// $a -> addAction = Methode


//Vérifier que dans le dossier controller qu'il y a bien
//le fichier UserController.class.php
//Sinon faire un die("Le fichier controller n'existe pas");
