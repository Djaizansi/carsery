<?php 
session_start();
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
					
					if(self::checkEmail($data[$name])){
						//Vérifier l'unicité de l'email
					}else{
						$listOfErrors[]=$config["errorMsg"];
					}
				}

					

				//Vérifier le captcha
					if($_SESSION["captcha"] != $_POST["captcha"]){
						$listOfErrors[]=$config["errorMsg"];
					}

				//Vérifier le password
					//Vérifier les confirm

				//Vérifier le min
				//Vérifier le max
			}

		}else{
			return ["Tentative de hack !!!"];
		}

		return $listOfErrors;
	}

	public static function checkEmail($email){
		$email = trim($email);
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public static function checkPwd($email){

	}
}