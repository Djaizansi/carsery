<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Session;
use carsery\core\View;
use carsery\Managers\ThemeManager;
use carsery\Managers\UserManager;
use carsery\models\User;

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

            // Récupération du thème actuel de l'utilisateur
            $userManager = new UserManager();
            $user = new User();
            $id = $_SESSION['id'];
            $foundActualTheme = $userManager->find($id);
            $result = $foundActualTheme->getTheme();
            $myView->assign("result", $result);

            // Changement de thème
            $findUser = $userManager->find($id);
            if (isset($_POST['form'])) {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (!empty($_POST)) {
                        $user->setId($findUser->getId());
                        $user->setLastname($findUser->getLastname());
                        $user->setFirstname($findUser->getFirstname());
                        $user->setEmail($findUser->getEmail());
                        $user->setPwd($findUser->getPwd());
                        $user->setStatus($findUser->getStatus());
                        $user->setToken($findUser->getToken());
                        $user->setTheme($_POST['theme']);
                        $user->setBan($findUser->isBan());
                        $userManager->save($user);
                    }
                }

                $msg = 'Le thème numéro ' . $_POST['theme'] . ' a été appliquer avec succès';
                $myView->assign("msg", $msg);

                // On redéclare $result dans le formulaire pour éviter un deuxième raffraichissement
                $foundActualTheme = $userManager->find($id);
                $result = $foundActualTheme->getTheme();
                $myView->assign("result", $result);
            }
        } else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}
