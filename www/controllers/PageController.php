<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;
use carsery\models\Page;
use carsery\Managers\PageManager;
use carsery\Managers\UserManager;
use carsery\models\Json;

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
            $titre = $pageFound->getTitre();
            $notiret = str_replace(' ','',strtolower($titre));

            if(isset($_GET['id']) && isset($_GET['token']) && $token == $_GET['token']){
                $pageManager->delete('id',$_GET['id']);
                /* $yaml = \yaml_parse_file("./router/routes.yml");
                $route = '/myproject/'.$titre_tiret; */
                /*  foreach($yaml as $key => $value){
                    if($key == $route){
                        unset($yaml[$key]);
                        $file = $yaml;
                        $arrayToYaml = \yaml_emit_file("./router/routes.yml",$file);
                    } */
                /* } */
                unlink("views/$notiret.view.php");
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
            if(!empty($_POST)){
                $pageExiste = "views/".$_POST['titre'].".view.php";
                if(file_exists($pageExiste)){
                    throw new RouteException("La page que vous voulez ajouter existe déjà");
                }else {
                    $titre_tiret = '/'.str_replace(' ','-',strtolower($_POST['titre']));
                    PageManager::addData($page,$pageManager,'',$_POST['titre'],$prenom,0,$titre_tiret,$token);

                    $location = Helpers::getUrl('Page','page');
                    header("Location: $location");
                    $unePage = $pageManager->findByTitre($_POST['titre']);
                    if(!empty($unePage)){
                            $titre = str_replace(' ','',strtolower($unePage->getTitre()));
                            file_put_contents("views/$titre.view.php",'coucou');
                            /* $titre_tiret = str_replace(' ','-',strtolower($unePage->getTitre())); */
                            /* $action = $unePage->getAction(); */
                            /* $route = '
/myproject/'.$titre_tiret.':
    controller: "myProject"
    action: "'.$action.'"
'; */
                        /* file_exists("router/routes.yml") ? file_put_contents("router/routes.yml",$route,FILE_APPEND) : Null;
                        echo Helpers::getView($action,$titre); */
                        /* $fileToEdit = file_get_contents($localisation);
                        //trouver la position de fin de fichier
                        $endOfFilePos= strpos($fileToEdit, "//End", -1); 
                        $myOldFileWithoutEnd = substr($fileToEdit, 0, $endOfFilePos);
                        $myNewEnd = $function . "\n }"; //les doubles guillemets sont importants pour interpréter le \n

                        //tout mettre dans le nouveau fichier
                        $myNewFile = file_put_contents ($localisation, $myOldFileWithoutEnd . $myNewEnd, FILE_APPEND); */
                        }
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
}
