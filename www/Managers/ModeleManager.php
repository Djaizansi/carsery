<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Modele;
use carsery\core\Helpers;
use carsery\core\Builder\QueryBuilder;


class ModeleManager extends DB {
    
    public function __construct()
    {
        parent::__construct(Modele::class, 'modeles');
    }

	
	/**
     * Vérifier si un modèle existe en bdd en fonction de son nom
     * @param type $name
     */
    public function findModele($name = null)
    {


        $query = (new QueryBuilder())
            ->select('*')
            ->from('ymnw_modeles', 'modele');
	    //->join('ymnw_marques', 'marque','marque','id');
		if($name) {
                
            $query->where('modele.nomModele = :name')
            ->setParameter(':name', $name);
        }

		return $query->getQuery()->getArrayResult(Modele::class) ;
        
    }

   
    /**
     * Retourne un tableau qui va constuire le formulaire d'insertion d'un modèle
     * @param type $action
     * @param type $idForm
     * @return array
     */
    public static function formModele($action, $idForm,$arraySelect = null) : array{
        return [
                    "config"=>[
                        "method"=>"POST", 
                        "action"=>$action,
                        "class"=>"box",
                        "id"=>$idForm,
                        "submit"=>"Confirmer"
                    ],
                        
                    "fields"=>[
                        
                        "modele"=>[
								"balise"=>"",
                                "type"=>"text",
                                "placeholder"=>"Votre nom de modèle",
                                "class"=>"",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>2,
                                "max-length"=>100,
                                "errorMsg"=>"Le nom du modèle est invalide"
                        ],
                        
                        "marque"=>[
								"balise"=>"",
                                "type"=>"select",
                                "placeholder"=>"Votre Marque",
                                "class"=>"box",
                                "id"=>"",
                                "required"=>true,
                                "valuesInSelect"=> $arraySelect,
                                "min-length"=>2,
                                "max-length"=>100,
                                "selected"=>true
                                //"errorMsg"=>"Le nom de la marque est invalide"   
                        ]
                        
                    ]
                   
                ];
    }

}
