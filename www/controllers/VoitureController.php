<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;
use carsery\core\QueryBuilder;
use carsery\Managers\VoitureManager;
use carsery\Managers\PostManager;
use carsery\Managers\MarqueManager;
use carsery\Managers\ModeleManager;
use carsery\core\Validator;
use carsery\models\Voiture;
use carsery\models\Modele;
use carsery\models\Marque;


class VoitureController {
	
	//Affichage des voitures coté Admin
    public function retrieveVoituresAction() 
    {   
        if(Session::estConnecte()){
            $myView = new View("gestionvoitures");

            $voitureManager = new VoitureManager();
			$allVoitures = $voitureManager->getVoitures() ;
            $myView->assign("allVoitures",$allVoitures);
			
        }

        else {
            throw new RouteException("Vous devez être connecté");
        }
    }
	
	//Liste des véhicules disponibles : coté client
	public function retrieveVoituresDisponibleAction() 
    {   
        if(Session::estConnecte()){
            $myView = new View("voituresdisponible");

            $voitureManager = new VoitureManager();
			$allVoituresDisponible = $voitureManager->getVoitureDisponible('Disponible') ;
            $myView->assign("allVoituresDisponible",$allVoituresDisponible);
        }

        else {
            throw new RouteException("Vous devez être connecté");
        }
    }
	
	public function updateVoitureAction(){
		
		if(isset($_GET['id'])){
		
			$voitureManager = new VoitureManager();
			$marqueManager = new MarqueManager();
			$modeleManager = new ModeleManager();
			//$unVoiture = $voitureManager->find($_GET['id']);
			$currentVoiture = $voitureManager->getCurrentVoiture(urldecode($_GET['id']));
			$listMarques = $marqueManager->findAll();
			$listModeles = $modeleManager->findAll();
		
			$myView = new View("editvoiture");
			$myView->assign('unVoiture',$currentVoiture);
			$myView->assign('listMarques',$listMarques);
			$myView->assign('listModeles',$listModeles);
		
		}
	}
	
	//Insertion d'un véhicule
    public function createVoitureAction(){

    	if(Session::estConnecte()){

    		$myView = new View("createvoiture");

	    	$marqueManager = new MarqueManager();
			$modeleManager = new modeleManager();
			$voitureManager = new VoitureManager();

			//Boucle for et explode en pushant dans le tableau $arrMarques : transformer un arr obj en arr multidimensionnel
			$arrMarques = [];
			foreach ($marqueManager->findAll() as $marque)  {

				array_push($arrMarques,explode(',',$marque->getNomMarque() ));
			}
			
			//Boucle for et explode en pushant dans le tableau $arrModeles : transformer un arr obj en arr multidimensionnel
			$arrModeles = [];
			foreach ($modeleManager->findAll() as $modele)  {

				array_push($arrModeles,explode(',',$modele->getNomModele() ));
			}

			//Création du formulaire Modèle : VoitureManager::formModele(action,id, données pour une liste déroulante)
	    	$configFormCreateVoiture = $voitureManager->formVoiture(
	            	Helpers::getUrl("Voiture", "createvoiture"),"formCreateVoiture",
	            	[$arrMarques,$arrModeles]);
					
			//Vérification des champs
			$errors = Validator::checkVoitureForm($configFormCreateVoiture ,$_POST);

			if($_SERVER["REQUEST_METHOD"] == "POST"){

				if(empty($errors)){
					
					/*Dans le select HTML option value="..." on n'a pas mentionné l'id mais plutot le nom de la marque ou du modèle.
					  Donc , on va récupérer un array objet qui contient le modèle ou la marque choisi(e).
					  On va parcourir les arrays objet et rajouter dans les setters leur id respectifs
					*/
					$currentModele = $modeleManager->findModele($_POST['modele']);
					$currentMarque = $marqueManager->findMarque($_POST['marque']);
					
					foreach($currentModele as $modele)
					foreach($currentMarque as $marque)

					$voiture = new Voiture( isset($_POST['immatriculation']) ? $_POST['immatriculation'] : null,
											isset($_POST['anneeCreation']) ? $_POST['anneeCreation'] : null,
											isset($_POST['compteur']) ? $_POST['compteur'] : null,
											isset($_POST['situation']) ? $_POST['situation'] : null,
											isset($_POST['etat']) ? $_POST['etat'] : null,
											$marque->getId()/*$modele->getMarque()->getId()*/ ,
											$modele->getId() ) ;

					//Vérifier que l'immatriculation ou le modèle n'existe pas en bdd avant l'ajout
					$foundVoiture = $voitureManager->findVoiture($voiture->getImmatriculation(),$modele->getNomModele());
					
					//Si c'est trouver message d'erreur
					if($foundVoiture){
						
						
						$errors[] = "L immatriculation et/ou la marque et/ou le modèle existe déjà" ;
						$myView->assign("errors", $errors);
					}
					
					else{
						
						$voitureManager->save($voiture);
						sleep(1);
						Helpers::redirect('/addVoiture');
					}

				}
				
			}

    		$myView->assign("configFormCreateVoiture",$configFormCreateVoiture);
			$myView->assign("errors", $errors);
    	}

    	else {
            throw new RouteException("Vous devez être connecté");
        }

    }
	
	
	//Suppression d'une voiture
    public function deleteVoitureAction(){
		
		if(isset($_GET)){
			
			$idVoiture = $_GET['id'] ;
            $voitureManager = new VoitureManager();
			
			//On recherche la voiture en bdd 
			$voiture = $voitureManager->find($idVoiture);
			
			//On la supprime
			$voitureManager->delete('id',$idVoiture);
	        Helpers::redirect('/gestionVoitures');
	    }

    }  

	//Insertion d'une marque
    public function createMarqueAction(){
		
		if(Session::estConnecte()){
			
			$myView = new View("createmarque");

			$marqueManager = new MarqueManager();
			
			//Création du formulaire Marque : MarqueManager::formMarque(action,id)
			$configFormCreateMarque = $marqueManager->formMarque(
						Helpers::getUrl("Voiture", "createMarque"),'formCreateMarque');


			//Vérification des champs
			$errors = Validator::checkMarqueForm($configFormCreateMarque ,$_POST);

			if($_SERVER["REQUEST_METHOD"] == "POST"){

				//Si le tableau d'erreurs est vide on ajoute en base de données
				if(empty($errors)){
							
					
					$marque = new Marque();
					$marque->setNomMarque(isset($_POST['marque']) ? $_POST['marque'] : null);
					
					//Vérifier que le nom de la marque n'existe pas en bdd avant l'ajout
					$foundMarque = $marqueManager->findMarque($marque->getNomMarque());
					
					//Si c'est trouver message d'erreur
					if($foundMarque){
						
						$errors[] = "La marque existe déjà" ;
						$myView->assign("errors", $errors);
					}
					
					else{
					
						$marqueManager->save($marque);
						sleep(1);
						Helpers::redirect('/addMarque');	
					}
				}
						
			}
			
			$myView->assign("configFormCreateMarque", $configFormCreateMarque);
			$myView->assign("errors", $errors);
		}
		
		else {
            throw new RouteException("Vous devez être connecté");
        }
			
    }

	//Insertion d'un modèle
    public function createModeleAction(){
		
		if(Session::estConnecte()){
			
			$myView = new View("createmodele");
			 
		 	$modeleManager = new ModeleManager();
		 	$marqueManager = new MarqueManager();

			//Récupération des marques de véhicule
			$arrMarques = [];
			
			//Boucle for et explode en pushant dans le tableau $arrMarques
			foreach ($marqueManager->findAll() as $value)  {

				array_push($arrMarques,explode(',',$value->getNomMarque() ));
			}
	
			//Création du formulaire Modèle : ModeleManager::formModele(action,id, données pour une liste déroulante)
			$configFormCreateModele = $modeleManager->formModele(
				Helpers::getUrl("Voiture", "createModele"),'formCreateModele',
				$arrMarques);
			

			//Vérification des champs
			$errors = Validator::checkModeleForm($configFormCreateModele ,$_POST);

			if($_SERVER["REQUEST_METHOD"] == "POST"){

				if(empty($errors)){

					/*Dans le select HTML option value="..." on n'a pas mentionné l'id mais plutot le nom de la marque.
					  Donc , on va récupérer un array objet qui contient  la marque choisie.
					  On va parcourir le array objet et rajouter dans le setter l'id respectif
					*/
					$currentMarque = $marqueManager->findMarque($_POST['marque']);
					foreach($currentMarque as $marque)
					
					$modele = new Modele(isset($_POST['modele']) ? $_POST['modele'] : null , $marque->getId());
					
					$foundModele = $modeleManager->findModele($modele->getNomModele(),$marque->getNomMarque());
					
					//Si c'est trouver message d'erreur
					if($foundModele){
						
						$errors[] = "Le modèle existe déjà" ;
						$myView->assign("errors", $errors);
					}
					
					//Sinon ajout
					else{
				
						$modeleManager->save($modele);
						sleep(1);
						Helpers::redirect('/addModele');
					}
				}

			}
			
			$myView->assign("configFormCreateModele", $configFormCreateModele);
			$myView->assign("errors", $errors);
		}
		
		else {
            throw new RouteException("Vous devez être connecté");
        }
	}
}
