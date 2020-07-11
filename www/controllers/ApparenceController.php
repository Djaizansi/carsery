<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Session;
use carsery\core\View;
use carsery\Managers\ThemeManager;

class ApparenceController
{
    public function apparenceAction()
    {
        if (Session::estConnecte()) {
            $myView = new View("apparence");

            // Affichage des thèmes disponibles
            $themeManager = new ThemeManager();
            $foundTheme = $themeManager->findAll();
            $myView->assign("foundTheme", $foundTheme);
        } else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}
