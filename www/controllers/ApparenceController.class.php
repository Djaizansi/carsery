<?php 
class ApparenceController {
    public function apparenceAction()
    {
        if(Session::estConnecte()){
            $myView = new View("apparence");
        }
    }
}