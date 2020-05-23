<?php 

namespace Carsery\Controllers;

require('models/vehicules.php');
require('models/marques.php');
require('models/modeles.php');

require('core/Helper.php');
require('core/View.php');

require('forms/VehiculeForm.php');
require('forms/MarqueForm.php');
require('forms/ModeleForm.php');
require('forms/DatatableForm.php');

use Carsery\Models\Vehicule;
use Carsery\Models\Marque;	
use Carsery\Models\Modele;	

use Carsery\Core\Helper;
use Carsery\Core\View;
use Carsery\Core\JsonObject;

use Carsery\Managers\VehiculeManager;

use Carsery\Forms\VehiculeForm;
use Carsery\Forms\MarqueForm;
use Carsery\Forms\ModeleForm;

    class VehiculeController {

        /**
         * Création d'un véhicule
         */
        public function createVehiculeAction(){
			
			$vehicule = new VehiculeManager();

			//UTILISATION DE L'INTERFACE JsonSerializable
			$jsonObject = new JsonObject($vehicule->find(2));
			print_r(json_encode($jsonObject,JSON_PRETTY_PRINT));
			
			$arrMarques = $vehicule->findBy("SELECT nomMarque FROM nfoz_marques 
				ORDER BY nomMarque",$this,null,'marques');

			$arrModeles = $vehicule->findBy("SELECT nomModele FROM nfoz_modeles 
				ORDER BY nomModele",$this,null,'modeles');


            $configFormCreateVehicule = VehiculeForm::formVehicule(
            	Helper::getUrl("vehicule", "createVehicule"),"formCreateVehicule",
            	[$arrMarques,$arrModeles]);

            //Vérification des champs
			$errors = Validator::checkForm($configFormCreateVehicule ,$_POST);

			if($_SERVER["REQUEST_METHOD"] == "POST"){
				
				//Insertion
				if(empty($errors)){
				
					$sql = "SELECT nfoz_modeles.id FROM nfoz_modeles 
					WHERE nfoz_modeles.nomModele = :nomModele";
					$params = [':nomModele' => $_POST['modele']];

					$query = "SELECT nfoz_marques.id FROM nfoz_marques 
					WHERE nfoz_marques.nomMarque = :nomMarque";
					$setting = [':nomMarque' => $_POST['marque']];

					$idModele = $vehicule->findBy($sql,$this,$params,'modeles');
					$idMarque = $vehicule->findBy($query,$this,$setting,'marques');
				
					foreach ($idMarque as $value) foreach ($value as $key => $marque_id) 
					foreach ($idModele as $v) foreach ($v as $k => $modele_id) 

					$vehicule->setImmatriculation(
						isset($_POST['immatriculation']) ? $_POST['immatriculation'] : null);
					$vehicule->setAnneeCreation(
						isset($_POST['anneeCreation']) ? $_POST['anneeCreation'] : null);
					$vehicule->setCompteur(
						isset($_POST['compteur']) ? $_POST['compteur'] : null);
					$vehicule->setSituation(
						isset($_POST['situation']) ? $_POST['situation'] : null);
					$vehicule->setEtat(
						isset($_POST['etat']) ? $_POST['etat'] : null);
					$vehicule->setIdMarque($marque_id);
					$vehicule->setIdModele($modele_id);
					
					$vehicule->save();
					
					sleep(1);
					header('Location: http://192.168.99.101/listVehicules');
					exit;
				}
			}
			
			$myView = new View("createVehicule", "account");
			$myView->assign("configFormCreateVehicule",$configFormCreateVehicule);
			$myView->assign("errors", $errors);

		}


?>
