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
use carsery\core\Mail;
use carsery\mail\template\ContactMail;

define('UPDATECONTACT', ContactManager::getUpdateForm());
define('ADDCONTACT', ContactManager::getContactForm());

class ContactController
{

    public function jsonAction()
    {
        $contactManager = new ContactManager();
        $contact = $contactManager->find(1)->__toArray();
        $json = new Json($contact);
        echo json_encode($json, JSON_PRETTY_PRINT);
    }

    public function contactAction()
    {
        if (Session::estConnecte()) {
            $contactManager = new ContactManager();
            $myView = new View("contact");
            $myView->assign('contactManager', $contactManager);
            $configFormContact = ContactManager::getContactForm();
            $errors = Validator::checkForm(UPDATECONTACT, $_POST);
            $myView->assign('configFormContact', $configFormContact);
            $myView->assign('formAddContact', ADDCONTACT);
            $myView->assign('formUpdateContact', UPDATECONTACT);
        } else {
            throw new RouteException("Vous devez être connecté");
        }
    }

    public function addContactAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $contactManager = new ContactManager();
            $contact = new Contact();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $errors = Validator::checkForm(ADDCONTACT, $_POST);
                if (!empty($errors)) {
                    return $this->contactAction();
                    $findContact = $contactManager->find((int)$_POST['id']);
                } else {
                    if (!empty($_POST)) {
                        $contact->setAdresse(htmlspecialchars($_POST['adresse']));
                        $contact->setNom(htmlspecialchars($_POST['nom']));
                        $contactManager->save($contact);
                        $_SESSION['success'] = "addContact";
                        header("Location: /contact");
                    }
                }
            }
        } else {
            throw new RouteException("Vous n'avez pas le droit à cette action");
        }
    }

    public function deleteContactAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $contactManager = new ContactManager();
            $id = isset($_GET['id']) ? $_GET['id'] : '';

            if ($id) {
                $contactManager->delete('id', $id);
                $location = Helpers::getUrl('Contact', 'contact');
                $_SESSION['success'] = 'suppContact';
                header("Location: $location");
            }
        } else {
            throw new RouteException("Vous n'avez pas le droit à cette action");
        }
    }

    public function updateContactAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $contactManager = new ContactManager();
            $contact = new Contact();
            $findContact = $contactManager->find((int)$_POST['id']);
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $errors = Validator::checkForm(UPDATECONTACT, $_POST);
                if (!empty($errors)) {
                    return $this->contactAction();
                } else {
                    if (!empty($_POST)) {
                        $contact->setId($_POST['id']);
                        $contact->setAdresse(htmlspecialchars($_POST['adresse']));
                        $contact->setNom(htmlspecialchars($_POST['nom']));
                        $contactManager->save($contact);
                        $_SESSION['success'] = "updateContact";
                        header("Location: /contact");
                    }
                }
            }
        } else {
            throw new RouteException("Vous n'avez pas le droit à cette action");
        }
    }

    public function sendContactAction() {
        $envoi = new Mail();
        $session = new Session();
        $message = htmlspecialchars($_POST['contact_message']);
        $magasin = htmlspecialchars($_POST['magasin']);
        $nom = htmlspecialchars($_POST['contact_nom']);
        $prenom = htmlspecialchars($_POST['contact_prenom']);
        $telephone = htmlspecialchars($_POST['contact_tel']);
        $mail = htmlspecialchars($_POST['contact_mail']);
        $unMail = ContactMail::sendContact($message,$magasin, $nom, $prenom, $mail, $telephone);
        $unEnvoi = $envoi->sendmail('Nouveau message de contact du magasin : ' .$magasin, $unMail, 'carsery@outlook.com');
        if($unEnvoi){
            $location = $_SESSION['uriContact'];
            $_SESSION['success'] = 'emailSend';
            header("Location: $location");
        }else {
            throw new RouteException("Un problème est survenue lors de l'envoi de mail");
        }
    }
}