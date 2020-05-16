<?php

namespace Carsery\Forms;

class ModeleForm{


	public static function formModele($action, $idForm,$arraySelect = null) : array{
        return [
                    "config"=>[
                        "method"=>"POST", 
                        "action"=>$action,
                        "class"=>"vehicule",
                        "id"=>$idForm,
                        "submit"=>"Confirmer"
                    ],
						
                    "fields"=>[
                        
                        "modele"=>[
                                "type"=>"text",
                                "placeholder"=>"Votre nom de modèle",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>2,
                                "max-length"=>100,
                                "errorMsg"=>"Le nom du modèle est invalide"
                        ],
						
						"marque"=>[
                                "type"=>"select",
                                "placeholder"=>"Votre Marque",
                                "class"=>"form-control form-control-user",
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
