<?php 

namespace Carsery\Controllers;

require('core/View.php');
use Carsery\Core\View; 
require('core\Session.php');
use Carsery\Core\Session; 

class MediaController {
    public function mediaAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("media");
        }
    }
}
