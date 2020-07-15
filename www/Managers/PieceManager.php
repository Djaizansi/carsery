<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Piece;
use carsery\core\Helpers; 
use carsery\core\Builder\QueryBuilder;


class PieceManager extends DB {
    
    public function __construct()
    {
        parent::__construct(Piece::class, 'pieces');
    }
	
	/**
     * Retourne un tableau qui va constuire le formulaire d'insertion d'une pièce
     * @param type $action
     * @param type $idForm
     * @return array
     */
    public static function formPiece($action, $idForm) : array {
        
        return [
                    "config"=>[
                        "method"=>"POST", 
                        "action"=>$action,
                        "class"=>"box",
                        "id"=>$idForm,
                        "submit"=>"Confirmer"
                    ],
					
                    "fields"=>[
                    
                        "nom"=>[
								"balise" => "",
                                "type"=>"text",
                                "placeholder"=>"Votre nom",
                                "class"=>"",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>"",
                                "max-length"=>"",
                                "errorMsg"=>"Le nom est invalide",
                            ],
							
						"description"=>[
								"balise" => "",
                                "type"=>"text",
                                "placeholder"=>"Votre description",
                                "class"=>"",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>"",
                                "max-length"=>"",
                                "errorMsg"=>"La description est invalide",
                            ],
						
						"prix"=>[
								"balise" => "",
                                "type"=>"text",
                                "placeholder"=>"Prix : 20.25 et non 20,25 ",
                                "class"=>"",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>"",
                                "max-length"=>"",
                                "errorMsg"=>"Le prix est invalide",
                            ],
						
						"reference"=>[
								"balise" => "",
                                "type"=>"text",
                                "placeholder"=>"reference",
                                "class"=>"",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>"",
                                "max-length"=>"",
                                "errorMsg"=>"La référence est invalide",
                            ],
							
						"stock"=>[
								"balise" => "",
                                "type"=>"number",
                                "placeholder"=>"Votre stock ",
                                "class"=>"",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>"",
                                "max-length"=>"",
                                "errorMsg"=>"Le stock est invalide",
                            ]
                            
                    ]
                ];
    }
}
