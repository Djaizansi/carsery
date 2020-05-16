<?php

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;
use carsery\models\page;
use carsery\models\users;

class PageController {
    public function pageAction() 
    {
        if(Session::estConnecte()){
            $page = new page();
            $myView = new View("page");
            $myView->assign('page',$page);
            $configFormPage = page::getPageForm();
            $myView->assign('configFormPage',$configFormPage);

        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function deletePageAction(){
        $page = new Page();
        $pageFound = $page->find('*','id',$_GET['id']);
        if(!isset($pageFound)){
            include_once "./error/404.php";
        }else {
            $titre = $pageFound->getTitre();
            $titre_tiret = str_replace(' ','-',strtolower($titre));
            $notiret = str_replace(' ','',strtolower($titre));
            unlink("views/$notiret.view.php");
            $page->delete('id',$_GET['id']);
            return $this->pageAction();
        }
    }

    public function addPageAction(){
        if(Session::estConnecte()){
            $page = new page();
            $user = new users();
            $localisation = "controllers/PageController.php";
            /* $lastLine = count($localisation);  */
            

            $findUser = $user->find('*','id',$_SESSION['id']);
            $prenom = $findUser->getFirstname();
            if(!empty($_POST)){
                isset($_POST['titre']) ? $page->setTitre($_POST['titre']) : '';
                $page->setAuteur($prenom);
                $page->setDate(date("Y-m-d H:i"));
                $page->setPublie(0);
                isset($_POST['action']) ? $page->setAction($_POST['action']) : '';
                $page->save();
                header('Location: /page');
                $unePage = $page->find('*','titre',$_POST['titre']);
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
                        $fileToEdit = file_get_contents($localisation);
                        //trouver la position de fin de fichier
                        $endOfFilePos= strpos($fileToEdit, "//End of file", -1); 
                        $myOldFileWithoutEnd = substr($fileToEdit, 0, $endOfFilePos);
                        $myNewEnd = $function . "\n }"; //les doubles guillemets sont importants pour interpréter le \n

                        //tout mettre dans le nouveau fichier
                        $myNewFile = file_put_contents ($localisation, $myOldFileWithoutEnd . $myNewEnd, FILE_APPEND);
                        }
                    } 
        }else{
            include_once "./error/notConnected.php";
        }
    }

    public function lienAction()
    {
        if(Session::estConnecte()){
            $myView = new View("lien");
        }else {
            include_once "./error/notConnected.php";
        }
    }
    //End of File
}