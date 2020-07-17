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

class testContactController {

    public function frontContactAction() {
        $myView = new View('testContact', 'template1');
    }
    public function sendContactAction() {
        $envoi = new Mail();
        $message = $_POST['contact_message'];
        $magasin = $_POST['magasin'];
        $nom = $_POST['contact_nom'];
        $prenom = $_POST['contact_prenom'];
        $telephone = $_POST['contact_tel'];
        $mail = $_POST['contact_mail'];
        $unMail = ContactMail::sendContact($message,$magasin, $nom, $prenom, $mail, $telephone);
        var_dump($unMail);
        $unEnvoi = $envoi->sendmail('Nouveau message de contact du magasin : ' .$magasin, $unMail, 'service.carsery@outlook.com');
        var_dump($unEnvoi);
        if($unEnvoi){
            var_dump($unMail);
            var_dump($unEnvoi);
            header("Location: /testcontact");
        }else {
            throw new RouteException("Un problème est survenue lors de l'envoi de mail");
        }
    }
}
?>