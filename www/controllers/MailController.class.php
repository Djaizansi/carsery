<?php 
class MailController {
    public function mailAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("mail");
        }
    }
}