<?php 
class ContactController {
    public function contactAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("contact");
        }
    }
}