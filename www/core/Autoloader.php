<?php 

	namespace Carsery\Core;

	class Autoloader{

		public function __construct(){
        
        	Autoloader::register();
    	
    	}
		
		
		static function register(){
		
			spl_autoload_register(array(__CLASS__,'autoload'));
			
		}
	
		
		static function autoload($class_name){


			$directoryPath = ["/","core/","models/","controllers/","forms/","managers/","router/"];

			foreach ($directoryPath as $path) {
		
				if(file_exists($path.$class_name.".php")){
		
					include $path.$class_name.".php";
				}
	
			}
		}
	}
