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
}
?>