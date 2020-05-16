<?php 

namespace Carsery\Forms;


class VehiculeForm{
	
    
    /**
     * Retourne un tableau qui va constuire le formulaire d'insertion ou de modification d'un véhicule
     * @param type $action
     * @param type $idForm
     * @param type $arraySelect
     * @return array
     */
    public static function formVehicule($action, $idForm,$arraySelect = null) : array {
        
        return [
                    "config"=>[
                        "method"=>"POST", 
                        "action"=>$action,
                        "class"=>"vehicule",
                        "id"=>$idForm,
                        "submit"=>"Confirmer"
                    ],
                    "fields"=>[
                    
                        "immatriculation"=>[
                                "type"=>"text",
                                "placeholder"=>"Votre Immatriculation : exemple AF-147-GT",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>9,
                                "max-length"=>9,
                                "errorMsg"=>"L'immatriculation est invalide"
                            ],
                            
                        "marque"=>[
                                "type"=>"select",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "valuesInSelect"=> $arraySelect[0],
                                // "min-length"=>2,
                                // "max-length"=>100,
                                //"errorMsg"=>"Votre marque doit faire entre 2 et 100 caractères"
                            ],
                            
                        "modele"=>[
                                "type"=>"select",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "valuesInSelect"=> $arraySelect[1],
                                // "min-length"=>2,
                                // "max-length"=>100,
                                //"errorMsg"=>"Votre modèle doit faire entre 2 et 100 caractères"
                            ],
                        
                        "compteur"=>[
                                "type"=>"number",
                                "placeholder"=>"Votre Compteur",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>2,
                                "max-length"=>10000000000,
                                "errorMsg"=>"Le compteur est invalide"
                            ],
                            
                        "anneeCreation"=>[
                                "type"=>"number",
                                "placeholder"=>"Votre Année de création",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>4,
                                "max-length"=>4,
                                "errorMsg"=>"L'année de création est invalide"
                            ],
                            
                        "etat"=>[
                                "type"=>"select",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "valuesInSelect"=> ['Disponible','Immobilisé','Loué'],
                                "valuesInSelect"=> $arraySelect[2] = [array('etat' => 'Disponible'),
                                                                      array('etat' => 'Immobilisé'),
                                                                      array('etat' => 'Loué')],
                                //"errorMsg"=>"Votre Etat doit faire entre 2 et 100 caractères"
                            ],
                            
                        "situation"=>[
                                "type"=>"select",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "valuesInSelect"=> $arraySelect[3] = [array('situation' => 'Neuf'),
                                                                      array('situation' => 'En occassion')],
                                //"errorMsg"=>"Votre Situation doit faire entre 2 et 100 caractères"
                            ]
                    ]
                ];
    }
   
}
