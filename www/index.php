<?php

function myAutoloader($class)
{
    $class = str_replace('carsery','',$class);

    $class = str_replace('\\', '/', $class);
    if($class[0] == '/'){
        include substr($class.'.php',1);
    }else {
        /* include 'controllers/'.$class.'.php'; */
    }
}

spl_autoload_register("myAutoloader");

use carsery\core\ConstantLoader;
use carsery\router\Router;



new ConstantLoader();
new Router();
