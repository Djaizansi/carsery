<?php 
namespace controllers; 

class PanierController {
    public function panierAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("panier");
        }
    }
}