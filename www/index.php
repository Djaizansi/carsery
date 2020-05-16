<?php

include('core/Autoloader.php');
include('core/ConstantLoader.php');
include('router/Router.php');

use Carsery\Core\ConstantLoader;
use Carsery\Core\Autoloader;
use Carsery\router\Router;

new Autoloader();
new ConstantLoader();
new Router();
