<?php 
class ForumController {
    public function forumAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("forum");
        }
    }
}