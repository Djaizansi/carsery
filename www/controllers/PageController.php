<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;
use carsery\models\Page;
use carsery\Managers\PageManager;
use carsery\Managers\UserManager;

class PageController {
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
        $pageFound = $pageManager->find($_GET['id']);
        if(!isset($pageFound)){
            throw new RouteException("La page que vous voulez supprimer n'existe pas ou plus");
        }else {
            $titre = $pageFound->getTitre();
            $titre_tiret = str_replace(' ','-',strtolower($titre));
            $notiret = str_replace(' ','',strtolower($titre));
            unlink("views/$notiret.view.php");
            $pageManager->delete('id',$_GET['id']);
            return $this->pageAction();
        }
    }

    public function addPageAction(){
        if(Session::estConnecte()){
            $page = new Page();
            $pageManager = new PageManager();
            $userManager = new UserManager();
            $localisation = "controllers/PageController.php";
            /* $lastLine = count($localisation);  */
            

            $findUser = $userManager->find($_SESSION['id']);
            $prenom = $findUser->getFirstname();
            if(!empty($_POST)){
                isset($_POST['titre']) ? $page->setTitre($_POST['titre']) : '';
                $page->setAuteur($prenom);
                $page->setDate(date("Y-m-d H:i"));
                $page->setPublie(0);
                isset($_POST['action']) ? $page->setAction($_POST['action']) : '';
                $pageManager->save($page);
                $location = Helpers::getUrl('Page','page');
                header("Location: $location");
                $unePage = $pageManager->findByTitre($_POST['titre']);
                if(!empty($unePage)){
                        $titre = str_replace(' ','',strtolower($unePage->getTitre()));
                        file_put_contents("views/$titre.view.php",'coucou');
                        $titre_tiret = str_replace(' ','-',strtolower($unePage->getTitre()));
                        $action = $unePage->getAction();
                        $route = '
/'.$titre_tiret.':
    controller: "Page"
    action: "'.$action.'"
';
                        $function = '
    public function '.$action.'Action(){
        $myView = new View("'.$titre.'","front");
    }
}';
                        file_exists("router/routes.yml") ? file_put_contents("router/routes.yml",$route,FILE_APPEND) : Null;
                        /* $fileToEdit = file_get_contents($localisation);
                        //trouver la position de fin de fichier
                        $endOfFilePos= strpos($fileToEdit, "//End of file", -1); 
                        $myOldFileWithoutEnd = substr($fileToEdit, 0, $endOfFilePos);
                        $myNewEnd = $function . "\n }"; //les doubles guillemets sont importants pour interpréter le \n

                        //tout mettre dans le nouveau fichier
                        $myNewFile = file_put_contents ($localisation, $myOldFileWithoutEnd . $myNewEnd, FILE_APPEND); */
                        }
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
        $pageManager = new PageManager();
        $configFormPage = PageManager::getWYSIWYGForm();
        $find = $pageManager->findAll();
        if($find && isset($_GET['id'])){
            $unePage = $pageManager->find($_GET['id']);
            $titre = $unePage->getTitre();
            $myView = new View("editpage");
            $myView->assign('pageManager', $pageManager);
            $myView->assign('configFormPage', $configFormPage);
            if(!empty($_POST)){
                isset($_POST['editPage']) ? $_POST['editPage'] : '';
                file_put_contents("Views/$titre.view.php", $_POST['editPage']);
                $location = Helpers::getUrl('Page','page');
                header("Location: $location");
            }
        }elseif(!$find && !isset($_GET['id'])){
            throw new RouteException("La modification n'est pas disponible ");
        }else {
            throw new RouteException("La page que vous voulez modifier n'existe pas ");
        }
    }
    //End of File
}
