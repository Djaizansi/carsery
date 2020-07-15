<?php 

namespace carsery\models;


use carsery\models\Model;
use carsery\models\User;
use carsery\models\Piece;

class Panier extends Model  {
    
    protected $id;
    protected $user;
    protected $piece;
    protected $quantite ;

    public function __construct($id = null, $user = null,$piece = null ,$quantite = null){
	
	$this->id = $id;
        $this->user = $user;
        $this->piece = $piece;
        $this->quantite = $quantite ;
    }
    


    /**
     *Initialisation des relations liées avec l'objet courant
     */
    public function initRelation(): array {
        return [
            'user' => User::class,
	        'piece' => Piece::class
        ];
    }


    /**
     * 
     * @param type $id
     */
    public function setId(int $id): self
    {
        $this->id=$id;
        return $this;
    }

    
    /**
     * 
     * @param \carsery\models\User $user
     */
    public function setUser(User $user) : Panier{
        $this->user = $user;
	    return $this ;
    }

    /**
     * 
     * @param \carsery\models\Piece $piece
     * @return $this
     */
    public function setPiece(Piece $piece) : Panier {
        $this->piece = $piece;
	    return $this;
    }

    /**
     * 
     * @param type $quantite
     */
    public function setQuantite($quantite){
        
    $this->quantite= (int)$quantite;
    }

    
    /**
     * 
     * @return type
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * 
     * @return type
     */
    public function getUser() : User {
        return $this->user;
    }

    /**
     * 
     * @return type
     */
    public function getPiece() : Piece {
        return $this->piece;
    }

    /**
     * 
     * @return type
     */
    public function getQuantite() {
        return $this->quantite;
    }

}

