<?php 

namespace controllers; 

class ParametreController {
    public function parametreAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("parametre");
        }
    }
}