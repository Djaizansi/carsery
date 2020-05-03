<?php 

namespace controllers; 

class MailController {
    public function mailAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("mail");
        }
    }
}