<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;


class ParametreController
{
    public function parametreAction()
    {
        if (Session::estConnecte()) {
            $myView = new View("parametre");
            $filename = "conf.inc.php";
            $file = $_SERVER['DOCUMENT_ROOT'] . '/' . $filename;
            if (file_exists($file)) {
                include_once($file);
            } else {
                $msg = "Impossible de récupérer les informations du site.";
                $myView->assign("msg", $msg);
            }
        } else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}
