<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;
use carsery\Managers\UserManager;
use carsery\Managers\VoitureManager;
use carsery\Managers\PieceManager;
use carsery\Managers\ShortCodeManager;
use carsery\Managers\PageManager;

class DashboardController
{
    public function dashboardAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $setVar = true;
            // setting the cookie
            setcookie('loader', $setVar ? '1' : '0');
            if (isset($_COOKIE['loader']) && $_COOKIE['loader'] === '1') :
            else :
?>
                <div class="loader-container" id="loader">
                    <div class="loader"></div>
                </div>
<?php
            endif;
            $myView = new View("dashboard");

            // Managers
            $userManager = new UserManager();
            $voitureManager = new VoitureManager();
            $pieceManager = new PieceManager();
            $shortcodeManager = new ShortCodeManager();
            $pageManager = new PageManager();

            // Récupération des données des tables
            $numberUser = $userManager->findAll();
            $foundVoiture = $voitureManager->findAll();
            $foundPiece = $pieceManager->findAll();
            $foundShortcode = $shortcodeManager->findAll();
            $foundPage = $pageManager->findAll();

            // Nombre de données
            $numberOfUser = count($numberUser);
            $numberOfVoiture = count($foundVoiture);
            $numberOfPiece = count($foundPiece);
            $numberOfShortcode = count($foundShortcode);
            $numberOfPage = count($foundPage);

            // Assign
            $myView->assign("numberOfUser", $numberOfUser);
            $myView->assign("numberOfVoiture", $numberOfVoiture);
            $myView->assign("numberOfPiece", $numberOfPiece);
            $myView->assign("numberOfShortcode", $numberOfShortcode);
            $myView->assign("numberOfPage", $numberOfPage);

            // Listes des utilisateurs
            $foundUser = $userManager->find($_SESSION['id']);
            $roleUserConnect = $foundUser->getStatus();
            $foundAll = $userManager->findAll();
            $myView->assign('foundAll', $foundAll);
            $myView->assign('userManager', $userManager);
            $myView->assign('roleUserConnect', $roleUserConnect);
        } else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}
