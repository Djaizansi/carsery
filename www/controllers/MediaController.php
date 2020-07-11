<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;

class MediaController {
    public function mediaAction() 
    {
        if(Session::estConnecte() && Session::estAdmin()){
            $myView = new View("media");
	    $alert = '';
            if(isset($_POST['upload'])){
                foreach($_FILES['file']['name'] as $file){
                    $validExt = ['.jpg', '.jpeg', '.png'];
                    $fileExt = "." . strtolower(substr(strrchr($file, '.'), 1));
                    if (!in_array($fileExt, $validExt)) {
                        $alert = 'image';
                        $myView->assign('alert',$alert);
                        break;
                    }else {
                        $file_name[] = $file;
                        $file_store[] = "./public/images_upload/".$file;
                    }
                }

                if($alert != 'image'){
                    foreach($_FILES['file']['tmp_name'] as $file){
                        $file_tem_loc[] = $file;
                    }

                    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                        if(move_uploaded_file($file_tem_loc[$i], $file_store[$i])){
                            $alert = 1;
                            $myView->assign('alert',$alert);
                        }else {
                            $alert = 2;
                            $myView->assign('alert',$alert);
                        }
                    }
                }elseif(is_null($alert)){
                    
                }
            }
        }else {
            throw new RouteException("Vous devez être connecté");
        }
    }

    public function suppMediaAction()
    {
        if(Session::estConnecte() && Session::estAdmin()){
            unlink('./public/images_upload/'.$_GET['file']);
            $_SESSION['success'] = 1;
            $location = Helpers::getUrl('Media','media');
            header("Location: $location");
        }else{
        }
    }

    public function testAction(){
        /***************************************************
         * Only these origins are allowed to upload images *
         ***************************************************/
        $accepted_origins = array("http://151.80.149.232");

        /*********************************************
         * Change this line to set the upload folder *
         *********************************************/
        $imageFolder = "public/images_upload/";
        reset ($_FILES);
        $temp = current($_FILES);

        if (is_uploaded_file($temp['tmp_name'])){
            if (isset($_SERVER['HTTP_ORIGIN'])) {
            // same-origin requests won't set an origin. If the origin is set, it must be valid.
            if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
                header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
            } else {
                header("HTTP/1.1 403 Origin Denied");
                return;
            }
            }

            /*
            If your script needs to receive cookies, set images_upload_credentials : true in
            the configuration and enable the following two headers.
            */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');

            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
                header("HTTP/1.1 400 Invalid file name.");
                return;
            }

            // Verify extension
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("jpeg", "jpg", "png"))) {
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $filetowrite = $imageFolder . $temp['name'];
            move_uploaded_file($temp['tmp_name'], $filetowrite);

            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
            echo json_encode(array('location' => $filetowrite));
        } else {
            // Notify editor that the upload failed
            header("HTTP/1.1 500 Server Error");
        }

    }
}
