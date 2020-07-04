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
        if(Session::estConnecte()){
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
        $pageManager = new PageManager();
        $page = new Page();
        $pageFound = $pageManager->find($_GET['id']);

        if(!isset($pageFound)){
            throw new RouteException("La page que vous voulez supprimer n'existe pas ou plus");
        }else {
            $token = $pageFound->getToken();


            if(isset($_GET['id']) && isset($_GET['token']) && $token == $_GET['token']){
                $pageManager->delete('id',$_GET['id']);
                return $this->pageAction();
            }else {
                throw new RouteException("Vous pouvez pas supprimer d'autre page aussi facilement");
            }
        }
    }

    public function addPageAction(){
        if(Session::estConnecte()){
            $token = Helpers::Salt(20);
            $page = new Page();
            $pageManager = new PageManager();
            $userManager = new UserManager();           

            $findUser = $userManager->find($_SESSION['id']);
            $prenom = $findUser->getFirstname();
            $titre_tiret = '/myproject/'.str_replace(' ','-',strtolower($_POST['titre']));
            $pageExist = $pageManager->findByUri($titre_tiret);
            if(!empty($_POST)){
                if($pageExist){
                    throw new RouteException("La page que vous voulez ajouter existe déjà");
                }
                $unMenu = isset($_POST['checkbox']) ? 1 : 0;
                $unPublic = isset($_POST['public']) ? 1 : 0;
                PageManager::addData($page,$pageManager,'',$_POST['titre'],$prenom,'Hello',$unPublic,$titre_tiret,$unMenu,$token);

                $location = Helpers::getUrl('Page','page');
                header("Location: $location");
            }
        }else{
            throw new RouteException("Vous devez être connecter pour accèder à cette page");
        }
    }

    public function lienAction()
    {
        if(Session::estConnecte()){
            $myView = new View("lien");
        }else {
            throw new RouteException("Vous devez être connecter pour accèder à cette page");
        }
    }

    public function modifierPageAction()
    {
        if(Session::estConnecte()){
            $token = Helpers::Salt(20);
            $pageManager = new PageManager();
            $page = new Page();
            $configFormPage = PageManager::getWYSIWYGForm();
            $find = $pageManager->findAll();
            if($find && isset($_GET['id'])){
                $unePage = $pageManager->find($_GET['id']);
                $auteur = $unePage->getAuteur();
                $uri = $unePage->getUri();
                $public = $unePage->getPublie();
                $menu = $unePage->getMenu();
                $titre = htmlspecialchars($unePage->getTitre());

                $myView = new View("editpage");
                $myView->assign('pageManager', $pageManager);
                $myView->assign('configFormPage', $configFormPage);
                if(!empty($_POST)){
                    isset($_POST['editPage']) ? $_POST['editPage'] : '';

                    $unMenu = isset($_POST['checkbox']) ? 1 : 0;
                    $unPublic = isset($_POST['public']) ? 1 : 0;
                    PageManager::addData($page,$pageManager,$_GET['id'], $titre,$auteur,$_POST['editPage'],$unPublic,$uri,$unMenu,$token);
                    $location = Helpers::getUrl('Page','page');
                    header("Location: $location");
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
        if(Session::estConnecte()){
            $pageManager = new PageManager();
            $page = new Page();
            $shortCodeManager = new ShortCodeManager();
            $shortCode = new Shortcode();
            $find = $pageManager->find($_GET['id']);
            if($find && isset($_GET['id'])){
                /* $unePage = $pageManager->find($_GET['id']);
                $titre = htmlspecialchars($unePage->getTitre());
                $auteur = $unePage->getAuteur();
                $content = $unePage->getContent();
                $unPublic = $unePage->getPublie();
                $uri = $unePage->getUri();
                $unMenu = $unePage->getMenu(); */
                /* $token = Helpers::Salt(20); */

                $myView = new View("widget");
                $myView->assign('shortCodeManager',$shortCodeManager);
                $myView->assign('shortCode',$shortCode);
                $myView->assign('pageManager', $pageManager);
                /* $myView->assign('page', $page);
                $myView->assign('titre',$titre);
                $myView->assign('auteur',$auteur);
                $myView->assign('content',$content);
                $myView->assign('unPublic',$unPublic);
                $myView->assign('uri',$uri);
                $myView->assign('unMenu',$unMenu);
                $myView->assign('token',$token); */


                if(!empty($_POST)){
                    isset($_POST['caroussel']) ? $_POST['caroussel'] : '';
                    isset($_POST['forum']) ? $_POST['forum'] : '';
                    isset($_POST['contact']) ? $_POST['contact'] : '';
                    isset($_POST['vehicule']) ? $_POST['vehicule'] : '';
                    isset($_POST['piece']) ? $_POST['piece'] : '';
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
}
