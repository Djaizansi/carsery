<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;
use carsery\models\Contact;
use carsery\Managers\ContactManager;
use carsery\models\Json;
use carsery\core\Validator;

define('CONFIGUPDATE', ContactManager::getUpdateForm());

class ContactController {

    public function jsonAction(){
        $contactManager = new ContactManager();
        $contact = $contactManager->find(1)->__toArray();
        $json = new Json($contact);
        echo json_encode($json,JSON_PRETTY_PRINT);
    }

    public function contactAction() 
    {
        if(Session::estConnecte()){
            $contactManager = new ContactManager();
            $myView = new View("contact");
            $myView->assign('contactManager',$contactManager);
            $configFormContact = ContactManager::getContactForm();
            $errors = Validator::checkForm(CONFIGUPDATE ,$_POST);
            $myView->assign('configFormContact',$configFormContact);
            $myView->assign('configFormContact',CONFIGUPDATE);

        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }

    public function addContactAction(){
        $contactManager = new ContactManager();
        $contact = new Contact();
        $contactFound = $contactManager->find($_GET['id']);

        if(!isset($contactFound)){
            throw new RouteException("Le contact que vous voulez ajouter existe deja");
        }else {
        }
    }

    public function deleteContactAction(){
        if(Session::estConnecte() && Session::estAdmin()){
            $contactManager = new ContactManager();
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            
            if($id){
                $contactManager->delete('id',$id);
                $location= Helpers::getUrl('Contact','contact');
                var_dump($location);
                $_SESSION['success'] = 'suppContact';
                header("Location: $location");
            }
        }else{
            throw new RouteException("Vous n'avez pas le droit à cette action");
        }
    }

    public function updateContactAction()
    {
        if(Session::estConnecte()){
            $contactManager = new ContactManager();
            $contact = new Contact();
            $findContact = $contactManager->find($_POST['id']);
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                    if(!empty($_POST)){
                        $contact->setId($_POST['id']);
                        $contact->setNom($_POST['nom']);
                        $contact->setAdresse($_POST['adresse']);
                        $contactManager->save($contact);
                        $_SESSION['success'] = "updateContact";
                        header("Location: /contact");
                    }
                }
        }else{
            throw new RouteException("Vous n'avez pas le droit à cette action");
        }
    }
}
