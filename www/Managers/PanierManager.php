<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Panier;
use carsery\models\Piece;
use carsery\core\Helpers; 
use carsery\core\Builder\QueryBuilder;

class PanierManager extends DB {

    
    public function __construct()
    {
        parent::__construct(Panier::class, 'paniers');
    }

    /**
     * Retourne le panier d'un utilisateur en fonction de son ID
     * @param type $idUser
     */
     public function getPanierUser(int $idUser = null)
    {

        $query = (new QueryBuilder())  
        ->select('p.*,panier.*')
        ->from('ymnw_paniers', 'panier')
        //->join('ymnw_users', 'u','user','id')
        ->join('ymnw_pieces', 'p','piece','id');
            
        if($idUser) {
                
            $query->where('panier.user = :idUser')
            ->setParameter('idUser', $idUser);
        }

        return $query->getQuery()->getArrayResult(Panier::class);
    }

	/**
     * Vérfier si une pièce est présente dans le panier d'un utilisateur en fonction de son ID et du nom de la pièce détachée
     * @param type $idUser
     */
    public function searchPieceIntoPanier($name = null, $idUser = null)
    {


        $query = (new QueryBuilder())
            ->select('panier.*, piece.*')
            ->from('ymnw_paniers', 'panier')
           //->join('ymnw_users', 'u','user','id')
	        ->join('ymnw_pieces', 'piece','piece','id');
	if($name || $idUser) {
                
            $query->where('piece.nomPiece = :name')
	        ->whereAnd('panier.user = :idUser')
            ->setParameter('name', $name)
            ->setParameter('idUser', $idUser);
        }
	
        return $query->getQuery()->getArrayResult(Panier::class) ;
    }
}
