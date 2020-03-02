<?php 
class PageController {
    public function pageAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("page");
        }
    }
}