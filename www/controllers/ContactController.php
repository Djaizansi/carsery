<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;
use carsery\models\Contact;
use carsery\Managers\ContactManager;
use carsery\models\Json;

class ContactController {

    public function jsonAction(){
        $userManager = new UserManager();
        $user = $userManager->find(1)->__toArray();
        $json = new Json($user);
        echo json_encode($json,JSON_PRETTY_PRINT);
    }

    public function contactAction() 
    {
        if(Session::estConnecte()){
            $contactManager = new ContactManager();
            $myView = new View("contact");
            $myView->assign('contactManager',$contactManager);
            $configFormContact = ContactManager::getContactForm();
            $myView->assign('configFormContact',$configFormContact);

        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }

    public function deleteContactAction(){
        $contactManager = new ContactManager();
        $contact = new Contact();
        $contactFound = $contactManager->find($_GET['id']);

        if(!isset($contactFound)){
            throw new RouteException("La contact que vous voulez supprimer n'existe pas ou plus");
        }else {
            $token = $contactFound->getToken();
            $titre = $contactFound->getTitre();
            $notiret = str_replace(' ','',strtolower($titre));

            if(isset($_GET['id']) && isset($_GET['token']) && $token == $_GET['token']){
                $contactManager->delete('id',$_GET['id']);
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
                return $this->contactAction();
            }else {
                throw new RouteException("Vous pouvez pas supprimer d'autre contact aussi facilement");
            }
        }
    }

    public function addContactAction(){
        if(Session::estConnecte()){
            $token = Helpers::Salt(20);
            $contact = new Contact();
            $contactManager = new ContactManager();
            $userManager = new UserManager();           

            $findUser = $userManager->find($_SESSION['id']);
            $prenom = $findUser->getFirstname();
            if(!empty($_POST)){
                $contactExiste = "views/".$_POST['titre'].".view.php";
                if(file_exists($contactExiste)){
                    throw new RouteException("La contact que vous voulez ajouter existe déjà");
                }else {
                    $titre_tiret = '/myproject/'.str_replace(' ','-',strtolower($_POST['titre']));
                    ContactManager::addData($contact,$contactManager,'',$_POST['titre'],$prenom,0,$titre_tiret,$token);

                    $location = Helpers::getUrl('Contact','contact');
                    header("Location: $location");
                    $uneContact = $contactManager->findByTitre($_POST['titre']);
                    if(!empty($uneContact)){
                            $titre = str_replace(' ','',strtolower($uneContact->getTitre()));
                            file_put_contents("views/$titre.view.php",'coucou');
                            /* $titre_tiret = str_replace(' ','-',strtolower($uneContact->getTitre())); */
                            /* $action = $uneContact->getAction(); */
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
            throw new RouteException("Vous devez être connecter pour accèder à cette contact");
        }
    }

    public function lienAction()
    {
        if(Session::estConnecte()){
            $myView = new View("lien");
        }else {
            throw new RouteException("Vous devez être connecter pour accèder à cette contact");
        }
    }

    public function modifierContactAction()
    {
        $contactManager = new ContactManager();
        $configFormContact = ContactManager::getWYSIWYGForm();
        $find = $contactManager->findAll();
        if($find && isset($_GET['id'])){
            $uneContact = $contactManager->find($_GET['id']);
            $titre = $uneContact->getTitre();
            $notiret = str_replace(' ','',strtolower($titre));
            $myView = new View("editcontact");
            $myView->assign('contactManager', $contactManager);
            $myView->assign('configFormContact', $configFormContact);
            if(!empty($_POST)){
                isset($_POST['editContact']) ? $_POST['editContact'] : '';
                file_put_contents("Views/$notiret.view.php", $_POST['editContact']);
                $location = Helpers::getUrl('Contact','contact');
                header("Location: $location");
            }
        }elseif(!$find && !isset($_GET['id'])){
            throw new RouteException("La modification n'est pas disponible ");
        }else {
            throw new RouteException("La contact que vous voulez modifier n'existe pas ");
        }
    }
}
