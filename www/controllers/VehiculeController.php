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

use Carsery\Forms\VehiculeForm;
use Carsery\Forms\MarqueForm;
use Carsery\Forms\ModeleForm;

    class VehiculeController {

        /**
         * Création d'un véhicule
         */
        public function createVehiculeAction(){
			
			$vehicule = new vehicules();
			
			$arrMarques = $vehicule->retrieveData("SELECT nomMarque FROM nfoz_marques 
				ORDER BY nomMarque",$this,null,'marques');

			$arrModeles = $vehicule->retrieveData("SELECT nomModele FROM nfoz_modeles 
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

					$idModele = $vehicule->retrieveData($sql,$params);
					$idMarque = $vehicule->retrieveData($query,$setting);
				
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
					exit();
				}
			}
			
			$myView = new View("createVehicule", "account");
			$myView->assign("configFormCreateVehicule",$configFormCreateVehicule);
			$myView->assign("errors", $errors);

		}

        /**
         * Modification d'un véhicule
         */

         public function updateVehiculeAction(){

            $configFormUpdateVehicule = VehiculeForm::formVehicule(
            	Helper::getUrl("vehicule", "updateVehicule"),"formUpdateVehicule");

			if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Vérification des champs
            $errors = Validator::checkForm($configFormUpdateVehicule ,$_POST);
            //Insertion ou erreurs
            print_r($errors);
			}
			
			$vehicule = new vehicules();
			$vehicule->setId();
			$vehicule->setImmatriculation();
			$vehicule->setAnneeCreation();
			$vehicule->setCompteur();
			$vehicule->setSituation();
			$vehicule->setEtat();
			$vehicule->setIdMarque();
			$vehicule->setIdModele();
			//$vehicule->save();
			//print_r($vehicule);

			$myView = new View("updateVehicule", "account");
			$myView->assign("configFormUpdateVehicule", $configFormUpdateVehicule);
         }

         /**
          * Suppression d'un véhicule
          */
         public function removeVehiculeAction(){

            echo('VehiculeController::removeVehiculeAction()');
			

         }   

         /**
          * Afficher la liste de tous les véhicules
          */
         public function retrieveVehiculesAction(){
			 
			$vehicule = new vehicules(); 
			
			$sql = "SELECT vehicule.id, vehicule.immatriculation, marque.nomMarque,
				modele.nomModele, vehicule.compteur, vehicule.anneeCreation,
				vehicule.situation,vehicule.etat 
				FROM nfoz_vehicules as vehicule INNER JOIN nfoz_marques as marque 
				ON vehicule.marque_id = marque.id 
				INNER JOIN nfoz_modeles as modele ON vehicule.modele_id = modele.id";
				
			$data = $vehicule->retrieveData($sql);

			$columnsName = array('ID','Immatriculation','Marque','Modèle',
                            'Compteur','Année de Création','Situation','Etat');

			$datatablesVehicules = DatatableForm::createDatatable(
				Helper::getUrl("vehicule", "retrieveVehicules"),"dataTableVehicules",
				$columnsName,$data);
			
			$myView = new View("tableVehicules", "account");
			$myView->assign("datatablesVehicules", $datatablesVehicules);

         }
		 
		 public function createMarqueAction(){
			 			
			$configFormCreateMarque = MarqueForm::formMarque(
				Helper::getUrl("vehicule", "createMarque"),'formCreateMarque');

			//Vérification des champs
			$errors = Validator::checkForm($configFormCreateMarque ,$_POST);

			if($_SERVER["REQUEST_METHOD"] == "POST"){


				
				if(empty($errors)){
				
					$marque = new marques();
					$marque->setNomMarque(isset($_POST['marque']) ? $_POST['marque'] : null);
					
					$marque->save();
					print_r($marque);
					
					sleep(1);
					header('Location: http://192.168.99.101/listMarques');
					exit();
					
				}
				
			}
			
			$myView = new View("createMarque", "account");
			$myView->assign("configFormCreateMarque", $configFormCreateMarque);
			$myView->assign("errors", $errors);
			
		 }

		 /**
          * Afficher la liste de toute les marques
          */
		  public function retrieveMarquesAction(){
			
			$marque = new marques();
				
			$data = $marque->retrieveData("SELECT id,nomMarque FROM nfoz_marques ;");
			$columnsName = array('ID','Intitulé');

			$datatablesMarques = DatatableForm::createDatatable(
				Helper::getUrl("vehicule", "retrieveMarques"),"dataTableMarques",
				$columnsName,$data);
			
			$myView = new View("tableMarques", "account");
			$myView->assign("datatablesMarques", $datatablesMarques);

         }
		 
		 public function createModeleAction(){
			 
		 	$modele = new modeles();

			$arrMarques = $modele->retrieveData("SELECT nomMarque FROM nfoz_marques 
				ORDER BY nomMarque");

			$configFormCreateModele = ModeleForm::formModele(
				Helper::getUrl("vehicule", "createModele"),'formCreateModele',$arrMarques);

			//Vérification des champs
			$errors = Validator::checkForm($configFormCreateModele ,$_POST);

			if($_SERVER["REQUEST_METHOD"] == "POST"){

				if(empty($errors)){

					$sql = "SELECT id FROM nfoz_marques WHERE nomMarque = :nomMarque";
					$params = [':nomMarque' => $_POST['marque'] ] ;
					
					$idMarque = $modele->retrieveData($sql,$params);
					foreach ($idMarque as $value) foreach ($value as $key => $marque_id) 

					$modele->setNomModele(isset($_POST['modele']) ? $_POST['modele'] : null );
					$modele->setIdMarque($marque_id);
					$modele->save();

					sleep(1);
					header('Location: http://192.168.99.101/listModeles');
					exit;
				}

			}
			
			$myView = new View("createModele", "account");
			$myView->assign("configFormCreateModele", $configFormCreateModele);
			$myView->assign("errors", $errors);


		}
		 
		 /**
          * Afficher la liste de tous les modèles
          */
		  public function retrieveModelesAction(){
			
			$modele = new modeles();

			$data = $modele->retrieveData("SELECT nfoz_modeles.id, nomMarque, nomModele FROM nfoz_modeles INNER JOIN nfoz_marques ON nfoz_modeles.marque_id = nfoz_marques.id;");
			//print_r($data);

			$columnsName = array('ID','Marque',"Modèle");

			$datatablesModeles = DatatableForm::createDatatable(
				Helper::getUrl("vehicule", "retrieveModeles"),"dataTableModeles",
				$columnsName,$data);
			
			$myView = new View("tableModeles", "account");
			$myView->assign("datatablesModeles", $datatablesModeles);
			
         }

    }

?>
