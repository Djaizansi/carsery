<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Marque;
use carsery\core\Helpers;
use carsery\core\Builder\QueryBuilder;


class MarqueManager extends DB {
    
    public function __construct()
    {
        parent::__construct(Marque::class, 'marques');
    }
	
	/**
     * Vérifier si une marque existe en bdd en fonction du nom de la marque
     * @param type $name
     */
	public function findMarque($name = null)
    {

        $query = (new QueryBuilder())
            ->select('*')
            ->from('ymnw_marques', 'm');
	if($name) {
                
            $query->where('m.nomMarque = :name')
            ->setParameter(':name', $name);
        }

    
        return $query->getQuery()->getArrayResult(Marque::class) ;
        
    }

    /**
     * Retourne un tableau qui va constuire le formulaire d'insertion d'une marque
     * @param type $action
     * @param type $idForm
     * @return array
     */
	public static function formMarque($action, $idForm) : array{
        return [
                    "config"=>[
					
                        "method"=>"POST", 
                        "action"=> $action,
                        "class"=>"box",
                        "id"=>$idForm,
                        "submit"=>"Confirmer"
                    ],
						
                    "fields"=>[
                        
                        "marque"=>[
								"balise"=>"",	
                                "type"=>"text",
                                "placeholder"=>"Votre nom de marque",
                                "class"=>"",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>"",
                                "max-length"=>"",
                                "errorMsg"=>"Le nom de la marque est invalide"
                        ]
                    ]
                   
                ];
    }
}

