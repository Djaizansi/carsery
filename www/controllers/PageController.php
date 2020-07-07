<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;
use carsery\models\Page;
use carsery\Managers\PageManager;
use carsery\Managers\ShortCodeManager;
use carsery\Managers\UserManager;
use carsery\models\Json;
use carsery\models\Shortcode;

class PageController {

    public function jsonAction(){
        $userManager = new UserManager();
        $user = $userManager->find(1)->__toArray();
        $json = new Json($user);
        echo json_encode($json,JSON_PRETTY_PRINT);
    }

    public function pageAction() 
    {
        if(Session::estConnecte() && Session::estAdmin()){
            $pageManager = new PageManager();
            $myView = new View("page");
            $myView->assign('pageManager',$pageManager);
            $configFormPage = PageManager::getPageForm();
            $myView->assign('configFormPage',$configFormPage);
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }

    public function deletePageAction(){
        if(Session::estConnecte() && Session::estAdmin()){
            $pageManager = new PageManager();
            $page = new Page();
            $pageFound = $pageManager->find($_GET['id']);

            if(!isset($pageFound)){
                throw new RouteException("La page que vous voulez supprimer n'existe pas ou plus");
            }else {
                $token = $pageFound->getToken();


                if(isset($_GET['id']) /* && isset($_GET['token']) && $token == $_GET['token'] */){
                    $pageManager->delete('id',$_GET['id']);
                    $location = Helpers::getUrl('Page','page');
                    header("Location: $location");
                }else {
                    throw new RouteException("Vous pouvez pas supprimer d'autre page aussi facilement");
                }
            }
        }else{
            throw new RouteException("Vous devez être connecté");
        }
    }

    public function addPageAction(){
        if(Session::estConnecte() && Session::estAdmin()){
            $token = Helpers::Salt(20);
            $page = new Page();
            $pageManager = new PageManager();
            $userManager = new UserManager();           

            $findUser = $userManager->find($_SESSION['id']);
            $prenom = $findUser->getFirstname();
            $titre_tiret = '/myproject/'.str_replace(' ','-',strtolower($_POST['titre']));
            $pageExist = $pageManager->findByUri($titre_tiret);
            $findAll = $pageManager->findAll();
            foreach($findAll as $myPage){
                if($myPage->getHome() == 1){
                    $homeExist = 1;
                }
            }
            if(!empty($_POST)){
                if($pageExist){
                    throw new RouteException("La page que vous voulez ajouter existe déjà");
                }else{
                    if(!isset($_POST['public']) && isset($_POST['checkbox'])){
                        $_SESSION['menu'] = 'erreurmenu';
                        $location = Helpers::getUrl('Page','page');
                        header("Location: $location");
                    }

                    elseif($homeExist == 1 && isset($_POST['home'])){
                        $_SESSION['menu'] = 'erreurmenu';
                        $location = Helpers::getUrl('Page','page');
                        header("Location: $location");
                    }

                    else{
                        $home = isset($_POST['home']) ? 1 : 0;
                        $unPublic = isset($_POST['public']) ? 1 : 0;
                        $unMenu = isset($_POST['checkbox']) ? 1 : 0;
                        if(empty($_SESSION['menu'])){
                            PageManager::addData($page,$pageManager,'',$_POST['titre'],$prenom,'Hello','',$unPublic,$titre_tiret,$unMenu,$home,$token);
                            $location = Helpers::getUrl('Page','page');
                            header("Location: $location");
                        }
                    }
                }
            }
        }else{
            throw new RouteException("Vous devez être connecter pour accèder à cette page");
        }
    }

    public function modifierPageAction()
    {
        if(Session::estConnecte() && Session::estAdmin()){
            $token = Helpers::Salt(20);
            $pageManager = new PageManager();
            $page = new Page();
            $configFormPage = PageManager::getWYSIWYGForm();
            $find = $pageManager->findAll();
            if($find && isset($_GET['id'])){
                $unePage = $pageManager->find($_GET['id']);
                $auteur = $unePage->getAuteur();
                $uri = $unePage->getUri();
                $date = $unePage->getDate();
                $titre = htmlspecialchars($unePage->getTitre());

                $myView = new View("editpage");
                $myView->assign('pageManager', $pageManager);
                $myView->assign('configFormPage', $configFormPage);
                foreach($find as $myPage){
                    if($myPage->getHome() == 1){
                        $homeExist = 1;
                    }
                }
                if(!empty($_POST)){
                    isset($_POST['editPage']) ? $_POST['editPage'] : '';
                    $home = isset($_POST['home']) ? 1 : 0;
                    
                    if(!isset($_POST['public']) && isset($_POST['checkbox'])){
                        $errors[] = "Vous ne pouvez pas mettre votre page dans le menu <br> Astuce : Vous devez publier votre page avant de pouvoir la mettre en menu";
                        $myView->assign('errors',$errors);
                    }

                    elseif(!isset($_POST['public'])){
                        $unPublic = 0;
                        $unMenu = 0;
                        if($unePage->getHome() == 0 && $homeExist == 1 && isset($_POST['home'])){
                            $errors[] = "Une page home existe déjà";
                            $myView->assign('errors',$errors);
                        }
                        elseif(empty($errors)){
                            PageManager::addData($page,$pageManager,$_GET['id'], $titre,$auteur,$_POST['editPage'],$date,$unPublic,$uri,$unMenu,$home,$token);
                            $location = Helpers::getUrl('Page','page');
                            header("Location: $location");
                        }
                    }

                    elseif(isset($_POST['public'])){
                        $unPublic = 1;
                        $unMenu = isset($_POST['checkbox']) ? 1 : 0;
                        if($unePage->getHome() == 0 && $homeExist == 1 && isset($_POST['home'])){
                            $errors[] = "Une page home existe déjà";
                            $myView->assign('errors',$errors);
                        }
                        elseif(empty($errors)){
                            PageManager::addData($page,$pageManager,$_GET['id'], $titre,$auteur,$_POST['editPage'],$date,$unPublic,$uri,$unMenu,$home,$token);
                            $location = Helpers::getUrl('Page','page');
                            header("Location: $location");
                        }
                    }
                }
            }elseif(!$find && !isset($_GET['id'])){
                throw new RouteException("La modification n'est pas disponible ");
            }else {
                throw new RouteException("La page que vous voulez modifier n'existe pas ");
            }
        }else {
            throw new RouteException("Vous devez être connecter pour accèder à cette page");
        }
    }

    public function widgetPageAction()
    {
        if(Session::estConnecte() && Session::estAdmin()){
            $pageManager = new PageManager();
            $page = new Page();
            $shortCodeManager = new ShortCodeManager();
            $shortCode = new Shortcode();
            $myView = new View("widget");
            $myView->assign('shortCodeManager',$shortCodeManager);
            $myView->assign('shortCode',$shortCode);
            $myView->assign('pageManager', $pageManager);
            /* if(!empty($_POST)){
                isset($_POST['caroussel']) ? $_POST['caroussel'] : '';
                isset($_POST['forum']) ? $_POST['forum'] : '';
                isset($_POST['contact']) ? $_POST['contact'] : '';
                isset($_POST['vehicule']) ? $_POST['vehicule'] : '';
                isset($_POST['piece']) ? $_POST['piece'] : '';
            } */
        }
        else {
            throw new RouteException("Vous devez être connecter pour accèder à cette page");
        }
    }
}
