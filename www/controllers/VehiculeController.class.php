<?php 

class VehiculeController {

        /**
         * Création d'un véhicule
         */
        public function createVehiculeAction(){
			
		$vehicule = new vehicules();
			
		echo'<pre>';
			
		$sql = "SELECT * FROM nfoz_vehicules WHERE nfoz_vehicules.situation = :situation ";
		$params = [':situation' => 'En occassion'];
		print_r($vehicule->retrieveData($sql,$this,$params));

		echo'</pre>';
	}
}
