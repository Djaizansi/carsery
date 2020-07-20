<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;
use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\Managers\PieceManager;
use carsery\Managers\PanierManager;
use carsery\core\Validator;
use carsery\models\Piece;

class PieceController {
	
	//Affichage des détachées coté admin
    public function pieceAction() 
    {   
        if(Session::estConnecte() && Session::estAdmin()){
            $myView = new View("gestionpieces");
			
			$pieceManager = new PieceManager();
			$myView->assign('allPieces',$pieceManager->findAll());
        }
		
		else {
            throw new RouteException("Vous devez être connecté");
        }
    }
	
	//Création de la pièce détachée
	public function createPieceAction(){
		
		if(Session::estConnecte() && Session::estAdmin()){
			
			$myView = new View("createpiece");

			$pieceManager = new PieceManager();
			
			//Création du formulaire de piece
			$configFormCreatePiece = $pieceManager->formPiece(Helpers::getUrl("Piece", "createPiece"),'jqueryForm');

			//Vérification des champs
			if(!empty($_POST)){
				$errors = Validator::checkPieceForm($configFormCreatePiece ,$_POST);
			}


			if($_SERVER["REQUEST_METHOD"] == "POST"){

				//Si tableau d'erreur est vide on crée la pièce détachéé 
				if(!empty($_POST)){
					if(!empty($errors)){
						$myView->assign("errors", $errors);
					}else{
							$piece = new Piece();	
							isset($_POST['nom']) ? htmlspecialchars($piece->setNomPiece($_POST['nom'])) : null;
							isset($_POST['description']) ? htmlspecialchars($piece->setDescription($_POST['description'])) : null;
							isset($_POST['prix']) ? $piece->setPrix((float) $_POST['prix']) : null;
							isset($_POST['reference']) ? htmlspecialchars($piece->setReference($_POST['reference'])) : null;
							isset($_POST['stock']) ? $piece->setStock($_POST['stock']) : null;

							$foundPiece = $pieceManager->findPiece($piece->getNomPiece(), $piece->getReference() );
							
							if( $foundPiece ){
								$errors[] = "La référence et/ou le nom de la pièce existe déjà" ;
								$myView->assign("errors", $errors);
							}	
							else{
								$pieceManager->save($piece);
								sleep(1);
								Helpers::redirect(Helpers::getUrl('Piece','piece'));	
							}
					}
				}
			}
			$myView->assign("configFormCreatePiece", $configFormCreatePiece);
		}
		
		else {
            throw new RouteException("Vous devez être connecté");
        }
			
    }
	
	//Affichage du formulaire de modification
	public function showFormUpdatePieceAction(){
			
			if(Session::estAdmin()){
				$myView = new View("editpiece");
				
				if($_SERVER["REQUEST_METHOD"] == "GET"){
				
					$pieceManager = new PieceManager();
							
					$idPiece = $_GET['id'];
								
					$currentPiece = $pieceManager->find($idPiece);
					
					$myView->assign("currentPiece", $currentPiece);
				}
			}
		}

		//Traiment du formulaire de modification
		public function editPieceAction(){
			
			if(Session::estConnecte() && Session::estAdmin()){
				
					
				if($_SERVER["REQUEST_METHOD"] == "POST"){
						
					//Field Hidden
					$id = $_POST['id'];
						
					//Regex
					$regexNom = "#^([A-Za-z]+[\s]{0,1}|[\s]{0,1}[\'-]{0,1}[\s]{0,1}|[\s]{0,1}[\',]{0,1}[\s]{0,1}[A-Za-z])*$#";
					$regexDescription = "#^([A-Za-z0-9]+[\s]{0,1}|[\s]{0,1}[\'-]{0,1}[\s]{0,1}|[\s]{0,1}[\',]{0,1}[\s]{0,1}|[\s]{0,1}[\':][\s]{0,1}[A-Za-z0-9])*$#";
					$regexPrix = "#^[0-9]+(\\.[0-9]{2})?$#";
					$regexReference = "#^([A-Za-z0-9]+[\s]{0,1}[\'-]{0,1}[\s]{0,1}|[\s]{0,1}[\'.]{0,1}[\s]{0,1}[A-Za-z0-9])+$#";
					$regexStock = "#^([0-9]+[^.])+$#";
						
					$nom = Validator::checkStringFields(htmlspecialchars($_POST['nom']),$regexNom);
					$description = Validator::checkStringFields(htmlspecialchars($_POST['description']),$regexDescription);
					$reference = Validator::checkStringFields($_POST['prix'],$regexPrix);
					$prix = Validator::checkStringFields(htmlspecialchars($_POST['reference']),$regexReference);
					$stock = Validator::checkStringFields($_POST['stock'],$regexStock);
								
							$pieceManager = new PieceManager();
							$piece = new Piece();
							$piece->setId(  isset($_POST['id']) ? $_POST['id'] : null);
							$piece->setNomPiece( isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : null ) ;
							$piece->setDescription(	isset($_POST['description']) ? htmlspecialchars($_POST['description']) : null ) ;
							$piece->setPrix(  isset($_POST['prix']) ? (float)$_POST['prix'] : null ) ;
							$piece->setReference(  isset($_POST['reference']) ? htmlspecialchars($_POST['reference']) : null );
							$piece->setStock( isset($_POST['stock']) ? $_POST['stock'] : null );

							$pieceManager->save($piece);
							Helpers::redirect('/gestionPieces');	

					//}
				}
			}

		else {
				throw new RouteException("Vous devez être connecté");
			}	 
		}

	//Suppression d'une pièce détachée
	public function removePieceAction(){

		if(Session::estAdmin()){
			if(isset($_POST)){
				
				//Récupération de l'id : hidden field
				$idPiece = $_POST['idPiece'] ;
				//print_r($idPiece);
				
				
				//Récupération de la pièce qu'on souhaite supprimer si elle existe en base de données
				$pieceManager = new PieceManager();
				$piece = $pieceManager->find($idPiece);
				
				$session = new Session(); // session_start()
				
				//Chercher si la pièce que l'on souhaite supprimer n'est pas déjà présente dans le panier du user courant
				$panierManager = new PanierManager();
				$found = $panierManager->searchPieceIntoPanier(  $piece->getNomPiece() , $_SESSION['id'] )  ;
				
				//Si la pièce n'est pas trouvée dans le panier du user courant, on la supprime en base de données
				if( !$found ){
					$pieceManager->delete('id', $idPiece );
					Helpers::redirect('/gestionPieces');
					
				}
				
				//Si la pièce est trouvé dans le panier de l'utilisateur : le stock de la pièce est à 0 
				/*elseif( $found ){
				if(  ! $found[0]->getPiece()->getStock() != 0){
					
						var_dump( $pieceManager->delete('id', $idPiece ) );
						Helpers::redirect('/gestionPieces');
					}
				}*/
				
				else{

					$messageError = "<strong>Vous ne pouvez pas supprimer une pièce existante dans le panier d'un ou plusieurs utilisateurs</strong>" ;
					print_r($messageError);
					print_r( "<script>setTimeout(\"location.href = '/gestionPieces';\",4000);</script>");
					
				}	        
			}
		}

    } 
}