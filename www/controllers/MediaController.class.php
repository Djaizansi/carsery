<?php 
class MediaController {
    public function mediaAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("media");
        }
    }
}