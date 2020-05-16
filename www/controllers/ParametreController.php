<?php 

namespace Carsery\Controllers;

require('core/View.php');
require('core\Session.php');
use Carsery\Core\Session; 
use Carsery\Core\View; 


class ParametreController {
    public function parametreAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("parametre");
        }
    }
}
