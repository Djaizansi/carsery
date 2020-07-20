<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;
use carsery\core\Validator;
use carsery\Managers\PageManager;
use carsery\Managers\UserManager;
use carsery\models\User;

$pageManager = new PageManager();
$allPage = $pageManager->findAll();

if(!isset($allPage) || empty($allPage)){
    $template = '';
}

foreach($allPage as $unePage){
    if($unePage->getTemplate() == 0){
        $template = 'template1';
    }elseif($unePage->getTemplate() == 1){
        $template = 'template2';
    }
}

define('TEMPLATE',$template);
define('CONFIGUPDATEUSER', UserManager::getFormProfile());

class ParametreController
{
    public function parametreAction()
    {
        if(Session::estAdmin()){
            $myView = new View("parametre");
        }else{
            $myView = new View("parametre",TEMPLATE);
        }
        if(!empty($_POST)){
            $errors = Validator::checkForm(CONFIGUPDATEUSER ,$_POST);
            $myView->assign('errors',$errors);
        }

        $myView->assign('configFormProfile',CONFIGUPDATEUSER);
        if (Session::estConnecte() && Session::estAdmin()) {
            $filename = "conf.inc.php";
            $file = $_SERVER['DOCUMENT_ROOT'] . '/' . $filename;
            if (file_exists($file)) {
                include_once($file);
            } else {
                $msg = "Impossible de récupérer les informations du site.";
                $myView->assign("msg", $msg);
            }
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }

    public function profileUserAction()
    {
        $userManager = new UserManager();
        $user = new User();
        $session = new Session();
        $findUser = $userManager->find($_SESSION['id']);
        if(!empty($_POST)){
            $errors = Validator::checkForm(CONFIGUPDATEUSER ,$_POST);
        }
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!empty($_POST)){
                if(!empty($errors)){
                    return $this->parametreAction();
                }else{
                        $user->setId($_SESSION['id']);
                        $user->setLastname(htmlspecialchars($_POST['lastname']));
                        $user->setFirstname(htmlspecialchars($_POST['firstname']));
                        $user->setEmail(htmlspecialchars($_POST['email']));
                        isset($_POST['pwd']) && !empty($_POST['pwd']) ? $user->setPwd(Helpers::cryptage($_POST['pwd'])) : $user->setPwd($findUser->getPwd());
                        $user->setStatus($findUser->getStatus());
                        $user->setTheme($findUser->getTheme());
                        $user->setBan($findUser->isBan());
                        $userManager->save($user);
                        $_SESSION['success'] = "updateProfile";
                        $location = Helpers::getUrl('Parametre','parametre');
                        header("Location: $location");
                    }
                }
            }
    }
}
