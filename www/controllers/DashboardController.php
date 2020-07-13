<?php 
namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;


class DashboardController {
    public function dashboardAction()
    {
        if(Session::estConnecte() && Session::estAdmin()){
            $setVar = true;
            // setting the cookie
            setcookie('loader', $setVar ? '1' : '0');
            if(isset($_COOKIE['loader']) && $_COOKIE['loader'] === '1'):
            else:
                ?>
                <div class="loader-container" id="loader">
                    <div class="loader"></div>
                </div>
                <?php
            endif;
            $myView = new View("dashboard");
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}