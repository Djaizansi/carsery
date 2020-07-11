<?php

// On lance l'installeur lorsque l'utilisateur lance une première fois Carsery

if (!file_exists('conf.inc.php')) {
    header("Location: installer/step_1.php");
    exit();
} else {
    if (file_exists("installer")) {
        header("Location: installer/step_3.php");
        exit();
    }
}

function myAutoloader($class)
{
    $class = str_replace('carsery', '', $class);

    $class = str_replace('\\', '/', $class);
    if ($class[0] == '/') {
        include substr($class . '.php', 1);
    } else {
        /* include 'controllers/'.$class.'.php'; */
    }
}

spl_autoload_register("myAutoloader");

use carsery\core\ConstantLoader;
use carsery\core\Exceptions\RouteException;
use carsery\router\Router;
use carsery\core\View;



new ConstantLoader();

try {
    $router = new Router();
} catch (RouteException $e) {
    $myView = new View('testerror', 'erreur');
    $error = $e->getMessage();
    $myView->assign('error', $error);
}
