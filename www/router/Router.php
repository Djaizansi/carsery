<?php

namespace Carsery\router;

class Router{

	public function __construct(){

		$this->routing();
	}


	public function routing(){

		//http://localhost/user/add -> $c = user et $a add
//http://localhost/user -> $c = user et $a default
//http://localhost -> $c = default et $a default
$uri = $_SERVER["REQUEST_URI"];
$listOfRoutes = yaml_parse_file("router/routes.yml");
if( !empty( $listOfRoutes[$uri] )  ){
	$c =  $listOfRoutes[$uri]["controller"]."Controller";
	$a =  $listOfRoutes[$uri]["action"]."Action";
	$pathController = "controllers/".$c.".php";
	if( file_exists($pathController)){
		include $pathController;
		//Vérifier que la class existe et si ce n'est pas le cas faites un die("La class controller n'existe pas")
		if( class_exists($c) ){
			$controller = new $c();
			
			//Vérifier que la méthode existeet si ce n'est pas le cas faites un die("L'action' n'existe pas")
			if( method_exists($controller, $a) ){
				
				//EXEMPLE :
				//$controller est une instance de la class UserController
				//$a = userAction est une méthode de la class UserController
				$controller->$a();
			}else{
				die("L'action' n'existe pas");
			}
		}else{
			die("La class controller n'existe pas");
		}
	}else{
		die("Le fichier controller n'existe pas");
	}
}else{
	die("L'url n'existe pas : Erreur 404");
}
	}
}
