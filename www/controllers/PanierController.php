<?php 

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\View;
use carsery\core\Session;
use carsery\core\Helpers;
use carsery\models\Panier;
use carsery\Managers\PieceManager;
use carsery\Managers\UserManager;
use carsery\Managers\PanierManager;
use carsery\core\Validator;


class PanierController {
	
	//Affichage de la liste des pièces détachées pour commande de pièce détachée 
    public function commandPieceAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("commandpiece");
	
			//Récupération de la liste des pièces
			$pieceManager = new PieceManager();
			$myView->assign('pieces',$pieceManager->findAll());   		
        }
		
		else {
            throw new RouteException("Vous devez être connecté");
        }
    }

	//Insertion d'une pièce détachée dans le Panier de l'utilisateur
    public function addPieceToPanierAction(){
		
		if(Session::estConnecte()){

			$pieceManager = new PieceManager();
			$userManager = new UserManager();
			$panierManager = new panierManager();
			
			//iniatialisé session_start();
			$session = new Session();

			if(isset($_POST)){

				echo'<pre>';
				$idPiece = $_POST['idPiece'];
				$quantite = $_POST['quantite'];
				
				//Récupération de l'utilisateur courant
				$user = $userManager->find($_SESSION['id']);

				//Récupération de la pièce courante
				$piece = $pieceManager->find($idPiece);
			
				//Ajout de la pièce dans le panier
				$panier = new Panier(null,$user->getId(),$piece->getId(),$quantite);
				
				//Modification du stock en fonction de la quantité choisie
				$currentPiece = $piece;
				$currentPiece->setStock($currentPiece->getStock() - $quantite);

				//Chercher si la pièce que l'on souhaite mettre dans le panier n'est pas déjà présente
				$found = $panierManager->searchPieceIntoPanier(  $piece->getNomPiece() , $_SESSION['id'] )  ;
				//print_r($found);
				

				//Récupération du panier de l'user courant
				$userPanier = $panierManager->getPanierUser($_SESSION['id']);
				//print_r($userPanier);
			
				//Comptage du nombre de pièces détachées dans le panier
				$nbPiecesPanierUser = count($userPanier) ;
				
				//Si la pièce n'est pas trouvée dans le panier  ou que le stock de pièce est supérieur 0
				if( ! $found ){
					
					//Si le nombre de pièces est différént de 4
					if( $nbPiecesPanierUser !=  3){

						//Insertion en base de données
						$panierManager->save($panier);
						
						//requete update sur le stock de la pièce
						$pieceManager->save($currentPiece);
						
						Helpers::redirect('/commandPiece');
					
					}
					
					else{
						
						$messageError = "<strong>Vous ne pouvez pas ajouter plus de 3 pièces détachées dans votre panier</strong>";
						print_r($messageError);
						print_r( "<script>setTimeout(\"location.href = '/commandPiece';\",4000);</script>");
					}
									
				}
				
				else{
					
					$messageError = "<strong>La pièce détachée existe déjà dans le panier </strong>";
					print_r($messageError);
					print_r( "<script>setTimeout(\"location.href = '/commandPiece';\",4000);</script>");
					
				}
				
				echo'</pre>';

			
			}
			
		}
		
		else {
            throw new RouteException("Vous devez être connecté");
        }
			
			
    }

	//Modification de la quantite d"une pièce détachée dans le Panier du user courant
	//Suppression d'une pièce détachée dans le Panier du user courant 
    public function updateQteDeletePieceAction(){


		if(Session::estConnecte()){
			
			$pieceManager = new PieceManager();
			$userManager = new UserManager();
			$panierManager = new PanierManager();
			$panier = new Panier();
			$session = new Session();

			if(isset($_POST)){

				echo'<pre>';
				$idPiece = $_POST['idPiece'];
				$idPanier = $_POST['idPanier'];
				$qteVoulue = $_POST['quantite'];
				/*echo'id Piece : <br />';
				print_r($idPiece);echo'<br />';
				echo'id Panier : <br />';
				print_r($idPanier);echo'<br />';
				echo'Qté : <br />';
				print_r($qteVoulue);echo'<br />';*/
		
				//Récupération de la pièce courante 
				$currentPiece = $pieceManager->find($idPiece);
				//print_r($currentPiece);
				
				//Récupération du panier courant
				$currentPanier = $panierManager->find($idPanier);		
				//print_r($currentPanier);
				
				$qteActuel = $currentPanier->getQuantite();
				//print_r($qteActuel); echo '<br />';
				//print_r($qteVoulue); echo '<br />';
				
				$qteTotal = 0;
				
				//Si la quantité actuel de la pièce courante > à la quantité voulue de la pièce courante
				if($qteActuel > $qteVoulue){// 11 > 8
					
					//Quantité actuelle - QUantité voulue
					$qteTotal =  $qteActuel - $qteVoulue ; //11 - 8 = 3
					print_r($qteTotal);
					
					//Réduction du stock de la pièce courante
					$currentPiece->setStock( $currentPiece->getStock() +  $qteTotal); //14 + 3
					//print_r($currentPiece);
					
					$panier = new Panier($currentPanier->getId(), $currentPanier->getUser()->getId(), $currentPanier->getPiece()->getId(), $qteVoulue);
					//print_r($panier);

					$panierManager->save($panier);
					$pieceManager->save($currentPiece);					
				}
				
				//Sinon si  la quantité actuel de la pièce courante < à la quantité voulue de la pièce courante
				elseif($qteActuel < $qteVoulue){ //11 < 15
					
					//Quantité voulue - Quantité actuelle
					$qteTotal =  $qteVoulue - $qteActuel ; //15 - 11 = 4
					//print_r($qteTotal);
					
					//Augmentation du stock de la pièce courante
					$currentPiece->setStock( $currentPiece->getStock() -  $qteTotal); //14 - 3
					//print_r($currentPiece);
					
					$panier = new Panier($currentPanier->getId(), $currentPanier->getUser()->getId(), $currentPanier->getPiece()->getId(), $qteVoulue);
					//print_r($panier);

					$panierManager->save($panier);
					$pieceManager->save($currentPiece);
				}
				
				else{
					
					//Suppression de la pièce dans le panier
					$panierManager->delete('id',$idPanier);
					
					//Comme le user n'a pas encore payer la quantité de la pièce  sera rajouté à son stock actuel.
					$currentPiece->setStock( $currentPiece->getStock()  + $qteVoulue); //14 + 15 = 25
					print_r($currentPiece);
					$pieceManager->save($currentPiece);
					
				}
				
				Helpers::redirect('/consultPanier');
				
				echo'</pre>';
				
			}
		}
		
		else {
            throw new RouteException("Vous devez être connecté");
        }
		
    }

	//Consulter le panier du user courant
    public function consultPanierAction(){
		
		if(Session::estConnecte()){

			$session = new Session();
			$panierManager = new PanierManager();
			$myView = new View('consultpanier');
			
			//Récupération du panier de l'user courant
			$userPanier = $panierManager->getPanierUser($_SESSION['id']);
			
			
			//Comptage du nombre de pièces détachées dans le panier
			$nbPiecesPanierUser = count($userPanier) ;
			
			//Calcule de la somme totale pour chaque pièce détachées : prix x quantité
			$totalSum = [] ;
			foreach($userPanier as $panier){
				 
				array_push( $totalSum, number_format($panier->getPiece()->getPrix() * $panier->getQuantite(),2) )  ;
			}
			
			//Calcule de la somme totale de l'ensemble du panier
			$sumCart = array_sum($totalSum);
			
			$myView->assign('userPanier',$userPanier);
			$myView->assign('nbPiecesPanierUser',$nbPiecesPanierUser);
			$myView->assign('sommePanier',$sumCart);

		}
		
		else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}