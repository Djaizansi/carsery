<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;

class MediaController {
    public function mediaAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("media");
            if(isset($_POST['upload'])){
                foreach($_FILES['file']['name'] as $file){
                    $file_name[] = $file;
                    $file_store[] = "./public/images_upload/".$file;
                }

                foreach($_FILES['file']['tmp_name'] as $file){
                    $file_tem_loc[] = $file;
                }

                for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                    if(move_uploaded_file($file_tem_loc[$i], $file_store[$i])){
                        echo "Le fichier a bien été uploadé !";
                    }else {
                        echo "Erreur survenue";
                    }
                }
            }
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}