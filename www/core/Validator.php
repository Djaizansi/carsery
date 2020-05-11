<?php 

namespace carsery\core;

use carsery\models\users;
use carsery\models\recuperation;


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
					$user = new users();
					$email = $user->find("email","email",$data[$name]);
					if(!(self::checkEmail($data[$name]))){
						$listOfErrors[]=$config["errorMsg"];
					}elseif($email){
						$listOfErrors[]="Votre email existe déjà";
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
					$user = new users();
					$email = $user->find("email","email",$data[$name]);
					if(!(self::checkEmail($data[$name]))){
						$listOfErrors[]=$config["errorMsg"];
					}elseif(!$email){
						$listOfErrors[]="Votre adresse mail est incorrect ou inexistante.";
					}
				}

				if($config['type']=="text" && $name = 'code'){
					$recup = new recuperation();
					$code = $recup->find('code','mail',$_SESSION['email']);
					$recup_code = $code->getCode();

					if($recup_code !== $data[$name]){
						$listOfErrors[]=$config["errorMsg"];
					}elseif(empty($data[$name])){
						$listOfErrors[]= "Veuillez entrer votre code de confirmation.";
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
}