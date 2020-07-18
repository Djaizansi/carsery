<?php 

namespace carsery\core;

use carsery\Managers\CategoryManager;
use carsery\Managers\UserManager;
use carsery\Managers\RecuperationManager;

class Validator{
	//$data = $_POST ou $_GET 
	public static function checkForm($configForm, $data){
		$listOfErrors = [];
		//Vérifications
		//Vérifier le nb de input
		if( count($configForm["fields"]) == count($data) ) {
			
			foreach ($configForm["fields"] as $name => $config) {

				//Vérifie que l'on a bien les champs attendus
				//Vérifier les required

				if( !array_key_exists($name, $data) || ( $config["required"] && empty($data[$name]) ) ){
					return ["Tentative de hack !!!"];
				}
				
				//Vérifier l'email


				if($config["type"]=="email"){
					$user = new UserManager();
					if(isset($data['id']) && !empty($data['id'])){
						$findUser = $user->find($data['id']);
						if($findUser->getEmail() === $data[$name]){
						}else{
							$email = $user->findByEmail($data[$name]);
							!is_null($email) ? $unEmail = $email->getEmail() : '';
							$mail = isset($unEmail) ? $unEmail : '';
							if(!(self::checkEmail($data[$name]))){
								$listOfErrors[]=$config["errorMsg"];
							}elseif($mail){
								$listOfErrors[]="Votre email existe déjà";
							}
						}
					}
				}

				//Vérifier le captcha
				if($config["type"]=="captcha"){
					if($_SESSION["captcha"] != $data[$name]){
						$listOfErrors[]=$config["errorMsg"];
					}
				}
				
					

				//Vérifier le password
					//Vérifier les confirm
					if($config["type"]=="password" && $name == "pwdConfirm"){
						if($data["pwd"] != $data["pwdConfirm"]){
							$listOfErrors[]=$config["errorMsg"];
						}
					}
					
					if($config["type"]=="password" && $name == "pwd"){
						$regex = '#(?=.*[a-z])(?=.*[A-Z])(?=.*\d)^[a-zA-Z\d]{6,16}$#';
						if(!(preg_match($regex,$data[$name]))){
							$listOfErrors[]=$config["errorMsg"];
						}
					}

				//Vérifier le min
				//Vérifier le max

				if($config["type"] == "text" && $name == "lastname"){
					if(strlen($data[$name]) < $config["min-lenght"] || strlen($data[$name]) > $config["max-lenght"]) {
						$listOfErrors[]=$config["errorMsg"];
					}
				}

				if($config["type"] == "text" && $name == "firstname"){
					if(strlen($data[$name]) < $config["min-lenght"] || strlen($data[$name]) > $config["max-lenght"]) {
						$listOfErrors[]=$config["errorMsg"];
					}
				}
			}
		}elseif($configForm['config']['id'] == 'jqueryForm'){
			return $listOfErrors;
		}else{
			return ["Tentative de hack !!!"];
		}
		return $listOfErrors;
	}

	public static function checkFormLogin($configForm, $data){
		$listOfErrors = [];
		//Vérifications

		//Vérifier le nb de input
		if( count($configForm["fields"]) == count($data) ) {
			
			foreach ($configForm["fields"] as $name => $config) {
				
				//Vérifie que l'on a bien les champs attendus
				//Vérifier les required
				if( !array_key_exists($name, $data) || ( $config["required"] && empty($data[$name]) ) ){
					return ["Tentative de hack !!!"];
				}
				
				//Vérifier l'email
				if($config["type"]=="email"){
					$user = new UserManager();
					$email = $user->findByEmail($data[$name]);
					!is_null($email) ? $unEmail = $email->getEmail() : '';
					$mail = isset($unEmail) ? $unEmail : '';
					if(!(self::checkEmail($data[$name]))){
						$listOfErrors[]=$config["errorMsg"];
					}elseif(!$mail){
						$listOfErrors[]="Votre email n'existe pas";
					}
				}

				if($config['type']=="text" && $name = 'code'){
					$recupManager = new RecuperationManager();
					$code = $recupManager->findByEmail($_SESSION['email']);
					isset($code) ? $recup_code = $code->getCode() : '';
					if(empty($recup_code) || $recup_code !== $data[$name]){
						$listOfErrors[]=$config["errorMsg"];
					}elseif(empty($data[$name])){
						$listOfErrors[]= "Veuillez entrer votre code de confirmation";
					}
				}
			}
		}else{
			return ["Tentative de hack !!!"];
		}
		return $listOfErrors;
	}

	

	public static function checkFormPwd($configForm, $data){
		$listOfErrors = [];
		//Vérifications

		//Vérifier le nb de input
		if( count($configForm["fields"]) == count($data) ) {
			
			foreach ($configForm["fields"] as $name => $config) {
				
				//Vérifie que l'on a bien les champs attendus
				//Vérifier les required

				if( !array_key_exists($name, $data) || ( $config["required"] && empty($data[$name]) ) ){
					return ["Tentative de hack !!!"];
				}

				if($config["type"]=="password" && $name == "pwdConfirm"){
					if($data["pwd"] != $data["pwdConfirm"]){
						$listOfErrors[]=$config["errorMsg"];
					}
				}
				
				if($config["type"]=="password" && $name == "pwd"){
					$regex = '#(?=.*[a-z])(?=.*[A-Z])(?=.*\d)^[a-zA-Z\d]{6,16}$#';
					if(!(preg_match($regex,$data[$name]))){
						$listOfErrors[]=$config["errorMsg"];
					}
				}
			}
		}else{
			return ["Tentative de hack !!!"];
		}
		return $listOfErrors;
	}

	public static function checkEmail($email){
		$email = htmlspecialchars(trim($email));
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public static function checkArticleForm($configForm, $data){
		$listOfErrors = [];
		//Vérifications

		//Vérifier le nb de input
		if( count($configForm["fields"]) == count($data) ) {
			
			foreach ($configForm["fields"] as $name => $config) {
				
				//Vérifie que l'on a bien les champs attendus
				//Vérifier les required

				if( !array_key_exists($name, $data) || ( $config["required"] && empty($data[$name]) ) ){
					return ["Tentative de hack !!!"];
				}

				if($config["type"] == "text" && $name == "titre"){
					if(strlen($data[$name]) < $config["min-lenght"] || strlen($data[$name]) > $config["max-lenght"]) {
						$listOfErrors[]=$config["errorMsg"];
					}
				}

				if($config["type"] == "text" && $name == "description"){
					if(strlen($data[$name]) < $config["min-lenght"]) {
						$listOfErrors[]=$config["errorMsg"];
					}
				}

				if($config["type"] == "relation" && $name == "categorie"){
					$categoryManager = new CategoryManager();
					if(!isset($data[$name]) || !is_numeric($data[$name])) {
						if($categoryManager->find($data[$name]) == null){
							$listOfErrors[]=$config["errorMsg"];
						}
					}
				}
			}
		}else{
			return ["Tentative de hack !!!"];
		}
		return $listOfErrors;
	}

    public static function checkMessageForm($configForm, $data){
        $listOfErrors = [];
        //Vérifications

        //Vérifier le nb de input
        if( count($configForm["fields"]) == count($data) ) {

            foreach ($configForm["fields"] as $name => $config) {

                //Vérifie que l'on a bien les champs attendus
                //Vérifier les required
                if( !array_key_exists($name, $data) || ( $config["required"] && empty($data[$name]) ) ){
                    return ["Tentative de hack !!!"];
                }

                if($config["type"] == "text" && $name == "message"){
                    if(strlen($data[$name]) < $config["min-lenght"]) {
                        $listOfErrors[]=$config["errorMsg"];
                    }
                }
            }
        }else{
            return ["Tentative de hack !!!"];
        }
        return $listOfErrors;
    }

    public static function checkCategoryForm($configForm, $data){
        $listOfErrors = [];
        //Vérifications

        //Vérifier le nb de input
        if( count($configForm["fields"]) == count($data) ) {

            foreach ($configForm["fields"] as $name => $config) {

                //Vérifie que l'on a bien les champs attendus
                //Vérifier les required
                if( !array_key_exists($name, $data) || ( $config["required"] && empty($data[$name]) ) ){
                    return ["Tentative de hack !!!"];
                }

                if($config["type"] == "text" && $name == "name"){
                    if(strlen($data[$name]) < $config["min-lenght"] && strlen($data[$name]) > $config["max-lenght"]) {
                        $listOfErrors[]=$config["errorMsg"];
                    }
                }
            }
        }else{
            return ["Tentative de hack !!!"];
        }
        return $listOfErrors;
    }
	
	/**
      * Vérifie que le formulaire de pièce détachée est conforme
      * @param type $configForm
      * @param type $data
      * @return type
      */
	public static function checkPieceForm($configForm, $data){
        $listOfErrors = [];
        //Vérifications
	print_r($listOfErrors);

        //Vérifier le nb de input
        if( count($configForm["fields"]) == count($data) ) {

	    echo'$data<br />';
	    $nbField_POST = count($data);
	    echo($nbField_POST); 

	    echo'$configForm<br />';
	    $configFormField = count($configForm["fields"]);
	    echo($configFormField); 

            foreach ($configForm["fields"] as $name => $config) {

		//echo'Boucle $configForm'; echo"\n";
		//print_r($configForm["fields"] );
		//print_r($config);

                //Vérifie que l'on a bien les champs attendus
                //Vérifier les required
                if( !array_key_exists($name, $data) || ( $config["required"] && empty($data[$name]) ) ){

		    echo"Est-ce que passe par là" ;
		    //print_r($name);
		    //print_r($data);
		    //print_r($config['required']);
		    //print_r($data[$name]);
		    
                    return ["Tentative de hack !!!"];
                }

		    echo'<pre>';
		    //print_r($name);
		    //print_r($data);
		    //print_r($config['required']);
		    //print_r($data[$name]);
		    //print_r($config['type']);
		    echo'</pre>';
		   
		    //echo $data[$name];
		    
		//Vérifier le nom de la pièce
	        if($config['type'] === "text" && $name == "nom"){
			
			echo'<pre>';
			echo $data[$name];
			echo'</pre>';
		  

			if(!self::checkStringFields(htmlspecialchars($data[$name]),
			   "#^([A-Za-z]+[\s]{0,1}|[\s]{0,1}[\'-]{0,1}[\s]{0,1}|[\s]{0,1}[\',]{0,1}[\s]{0,1}[A-Za-z])*$#")){

			   $listOfErrors[] = $config['errorMsg'];
			}
		}

		//Vérfier la description de la pièce
		if($config['type'] === "text" && $name == "description"){

			echo'<pre>';
			echo $data[$name];
			echo'</pre>';

			if(!self::checkStringFields(htmlspecialchars($data[$name]),
			   "#^([A-Za-z0-9]+[\s]{0,1}|[\s]{0,1}[\'-]{0,1}[\s]{0,1}|[\s]{0,1}[\',]{0,1}[\s]{0,1}|[\s]{0,1}[\':][\s]{0,1}[A-Za-z0-9])*$#")){

			   $listOfErrors[] = $config['errorMsg'];
			}
		}

		//Vérifier le prix de la pièce
		if($config['type'] === "text" && $name == "prix"){

			echo'<pre>';
			echo $data[$name];
			echo'</pre>';

			if(!self::checkStringFields($data[$name],"#^[0-9]+(\\.[0-9]{2})?$#")){

			   $listOfErrors[] = $config['errorMsg'];
			}
		}

		//Vérifier la référence de la pièce
		if($config['type'] === "text" && $name == "reference"){

			echo'<pre>';
			echo $data[$name];
			echo'</pre>';

			if(!self::checkStringFields(htmlspecialchars($data[$name]),
			   "#^([A-Za-z0-9]+[\s]{0,1}[\'-]{0,1}[\s]{0,1}|[\s]{0,1}[\'.]{0,1}[\s]{0,1}[A-Za-z0-9])+$#")){

			   $listOfErrors[] = $config['errorMsg'];
			}
		}

		//Vérifier le stock de la pièce
		if($config['type'] === "number" && $name == "stock"){

			echo'<pre>';
			echo $data[$name];
			echo'</pre>';

			if(!self::checkStringFields($data[$name],"#^([0-9]+[^.])+$#")){

			   $listOfErrors[] = $config['errorMsg'];
			}
		}
                
            }
        }

		else{

			echo'Dommage , vous etes passez par là <br />';
				return ["Tentative de hack !!!"];
			}
			return $listOfErrors;
    }
	
	/**
      * Vérifie que le formulaire de marque est conforme
      * @param type $configForm
      * @param type $data
      * @return type
      */
	public static function checkMarqueForm($configForm, $data){
        $listOfErrors = [];
        //Vérifications
	print_r($listOfErrors);

        //Vérifier le nb de input
        if( count($configForm["fields"]) == count($data) ) {

	    $nbField_POST = count($data);

	    $configFormField = count($configForm["fields"]);

            foreach ($configForm["fields"] as $name => $config) {


                //Vérifie que l'on a bien les champs attendus
                //Vérifier les required
                if( !array_key_exists($name, $data) || ( $config["required"] && empty($data[$name]) ) ){

		    
                    return ["Tentative de hack !!!"];
                }

			
			//Vérifier le nom de la marque
			if($config['type'] === "text" && $name == "marque"){

					if(!self::checkStringFields(htmlspecialchars($data[$name]),
							"#^[A-Za-z]+([\s]{0,1}|[\'-]{0,1})[A-Za-z]+[\s]{0,1}$#")){

							$listOfErrors[] = $config['errorMsg'];
						}
		}
                
            }
        }

	else{

            return ["Tentative de hack !!!"];
        }
        return $listOfErrors;
    }
	
    /**
     * Vérifie que le formulaire de modèle est conforme
     * @param type $configForm
     * @param type $data
     * @return type
     */
	public static function checkModeleForm($configForm, $data){
        $listOfErrors = [];
        //Vérifications

        //Vérifier le nb de input
        if( count($configForm["fields"]) == count($data) ) {

	    $nbField_POST = count($data);

	    $configFormField = count($configForm["fields"]);

            foreach ($configForm["fields"] as $name => $config) {

                //Vérifie que l'on a bien les champs attendus
                //Vérifier les required
                if( !array_key_exists($name, $data) || ( $config["required"] && empty($data[$name]) ) ){

		    
                    return ["Tentative de hack !!!"];
                }

			
			//Vérifier le nom du modèle
			if($config['type'] === "text" && $name == "modele"){

					if(!self::checkStringFields(htmlspecialchars($data[$name]),
						"#^[A-Za-z]+([\s]{0,1}|[\s]{0,1}[\'-]{0,1}[\s]{0,1})[A-Za-z]+[\s]{0,1}[0-9]{0,3}$#")){

							$listOfErrors[]=$config["errorMsg"];
						}
		}
                
            }
        }

	else{

            return ["Tentative de hack !!!"];
        }
        return $listOfErrors;
    }
	
    /**
     * Vérifie que le formulaire de voiture est conforme
     * @param type $configForm
     * @param type $data
     * @return type
     */
	public static function checkVoitureForm($configForm, $data){
        $listOfErrors = [];
        //Vérifications

        //Vérifier le nb de input
        if( count($configForm["fields"]) == count($data) ) {

	    $nbField_POST = count($data);

	    $configFormField = count($configForm["fields"]);
	   

            foreach ($configForm["fields"] as $name => $config) {


                //Vérifie que l'on a bien les champs attendus
                //Vérifier les required
                if( !array_key_exists($name, $data) || ( $config["required"] && empty($data[$name]) ) ){

		    
                    return ["Tentative de hack !!!"];
                }

			
			//Vérifier l'immatriculation
			if($config['type'] === "text" && $name == "immatriculation"){

					if(!self::checkStringFields($data[$name],
						"#^[A-Z]{2}-[0-9]{3}-[A-Z]{2}$#")){

							$listOfErrors[]=$config["errorMsg"];
					}

				}

			//Vérifier le compteur
			if($config['type'] === "number" && $name == "compteur"){

					if( !self::checkCompteurField($data[$name]) ){

							$listOfErrors[]=$config["errorMsg"];
					}

				}

			//Vérifier l'année de création
			if($config['type'] === "number" && $name == "anneeCreation"){

					if( !self::checkAnneCreationField($data[$name]) ){

							$listOfErrors[]=$config["errorMsg"];
						}
		}
                
            }
        }

	else{
            return ["Tentative de hack !!!"];
        }
        return $listOfErrors;
    }
}
