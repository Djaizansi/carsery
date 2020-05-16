<?php

namespace Carsery\Forms;

class MarqueForm{
	
	public static function formMarque($action, $idForm) : array{
        return [
                    "config"=>[
					
                        "method"=>"POST", 
                        "action"=> $action,
                        "class"=>"vehicule",
                        "id"=>$idForm,
                        "submit"=>"Confirmer"
                    ],
						
                    "fields"=>[
                        
                        "marque"=>[
						
                                "type"=>"text",
                                "placeholder"=>"Votre nom de marque",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>2,
                                "max-length"=>100,
                                "errorMsg"=>"Le nom de la marque est invalide"
                        ]

                    ]
                   
                ];
    }


    public static function datatableMarques($dataDataTable = null){
        return [
                    "configDatatable"=>[
                  
                        "action"=>Helper::getUrl("vehicule", "retrieveVehicules"),
                        "class"=>"vehicule",
                        "id"=>"dataTableVehicules",
                        "width"=>"100%",
                        "cellspacing"=>"0",
                    ],
                    
                    "dataDataTable"=> [
                        
                        "nameColumnsDatatable"=>['ID','Immatriculation','Marque','Modèle',
                            'Compteur','Année de Création','Situation','Etat'],
                        "rows"=> $dataDataTable,
                    ]       
        ];
    }
	
}
