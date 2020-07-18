<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Voiture;
use carsery\core\Builder\QueryBuilder;


class VoitureManager extends DB {
    
    public function __construct()
    {
        parent::__construct(Voiture::class, 'voitures');
    }

	/**
     * Retourne la liste des voitures avec les relations liées aux voitures ( jointures )
     */
    public function getVoitures()
    {

        $query = (new QueryBuilder())
            
        ->select('voiture.*, marque.nomMarque, modele.nomModele')
        ->from('ymnw_voitures', 'voiture')
        ->join('ymnw_marques', 'marque','marque','id')
	    ->join('ymnw_modeles', 'modele','modele','id');

            return $query->getQuery()->getArrayResult(Voiture::class);
        
    }

	/**
     * Retourne un objet voiture en fonction de son ID 
     * @param type $id
     */
     public function getCurrentVoiture(int $id = null)
    {


        $query = (new QueryBuilder())
            
        ->select('voiture.*, marque.nomMarque, modele.nomModele')
        ->from('ymnw_voitures', 'voiture')
        ->join('ymnw_marques', 'marque','marque','id')
        ->join('ymnw_modeles', 'modele','modele','id');
            
         if($id) {
                $query->where('voiture.id = :id')
                ->setParameter('id', $id);
            }
         
		 return $query->getQuery()->getArrayResult(Voiture::class);
        
    }
	 
	/**
     * Retourne la liste des voitures disponibles 
     * @param type $etat
     */
     public function getVoitureDisponible($etat = null)
    {

        $query = (new QueryBuilder())
            
        ->select('voiture.*, marque.nomMarque, modele.nomModele')
        ->from('ymnw_voitures', 'voiture')
        ->join('ymnw_marques', 'marque','marque','id')
        ->join('ymnw_modeles', 'modele','modele','id');
            
        if($etat) {
                
				$query->where('voiture.etat = :etat')
                ->setParameter('etat', $etat);
        }

        return $query->getQuery()->getArrayResult(Voiture::class);
        
    }
	
	/**
     * Vérifie si une voiture existe en bdd en fonction de son immatriculation et de son modèle
     * @param type $immatriculation
	 * @param type $modele_id
     */
     public function findVoiture($immatriculation = null, $modele = null, $marque = null)
    {

        $query = (new QueryBuilder())
            
        ->select('voiture.*, modele.nomModele, marque.nomMarque')
        ->from('ymnw_voitures', 'voiture')
        ->join('ymnw_marques', 'marque','marque','id')
        ->join('ymnw_modeles', 'modele','modele','id');
            
        if($immatriculation || $modele/* || $marque*/) {
                
			$query->where('voiture.immatriculation= :immatriculation')
			->orCondition('modele.nomModele = :modele')
			//->orCondition('marque.nomMarque = :marque')
			//->whereAnd('marque.nomMarque = :marque')
			->setParameter('immatriculation', $immatriculation)
            ->setParameter('modele', $modele);
	    //->setParameter('marque', $marque);
	    

        }

        return $query->getQuery()->getArrayResult(Voiture::class);
        
    }
	
	

    /**
     * Retourne un tableau qui va constuire le formulaire d'insertion ou de modification d'un véhicule
     * @param type $action
     * @param type $idForm
     * @param type $arraySelect
     * @return array
     */
    public static function formVoiture($action, $idForm,$arraySelect = null) : array {
        
        return [
                    "config"=>[
                        "method"=>"POST", 
                        "action"=>$action,
                        "class"=>"box",
                        "id"=>$idForm,
                        "submit"=>"Confirmer"
                    ],
                    "fields"=>[
                    
                        "immatriculation"=>[
								"balise"=>"",
                                "type"=>"text",
                                "placeholder"=>"Votre Immatriculation : exemple AF-147-GT",
                                "class"=>"box",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>9,
                                "max-length"=>9,
                                "errorMsg"=>"L'immatriculation est invalide"
                            ],
                            
                        "marque"=>[
								"balise"=>"",
                                "type"=>"select",
                                "class"=>"box",
                                "id"=>"",
                                "required"=>true,
                                "valuesInSelect"=> $arraySelect[0],
                                "min-length"=>"",
                                "max-length"=>"",
                                //"errorMsg"=>"Votre marque doit faire entre 2 et 100 caractères"
                            ],
                            
                        "modele"=>[
								"balise"=>"",
                                "type"=>"select",
                                "class"=>"box",
                                "id"=>"",
                                "required"=>true,
                                "valuesInSelect"=> $arraySelect[1],
                                "min-length"=>"",
                                "max-length"=>"",
                                //"errorMsg"=>"Votre modèle doit faire entre 2 et 100 caractères"
                            ],
                        
                        "compteur"=>[
								"balise"=>"",
                                "type"=>"number",
                                "placeholder"=>"Votre Compteur",
                                "class"=>"",
                                "id"=>"box",
                                "required"=>true,
                                "min-length"=>"",
                                "max-length"=>"",
                                "errorMsg"=>"Le compteur est invalide"
                            ],
                            
                        "anneeCreation"=>[
								"balise"=>"",
                                "type"=>"number",
                                "placeholder"=>"Votre Année de création",
                                "class"=>"box",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>4,
                                "max-length"=>4,
                                "errorMsg"=>"L'année de création est invalide"
                            ],
                            
                        "etat"=>[
								"balise"=>"",
                                "type"=>"select",
                                "class"=>"box",
                                "id"=>"",
                                "required"=>true,
                                //"valuesInSelect"=> ['Disponible','Immobilisé','Loué'],
                                "valuesInSelect"=> $arraySelect[2] = [array('etat' => 'Disponible'), array('etat' => 'Non Disponible')],
                                //"errorMsg"=>"Votre Etat doit faire entre 2 et 100 caractères"
                            ],
                            
                        "situation"=>[
								"balise"=>"",
                                "type"=>"select",
                                "class"=>"box",
                                "id"=>"",
                                "required"=>true,
                                "valuesInSelect"=> $arraySelect[3] = [array('situation' => 'Neuf'), array('situation' => 'En occassion')],
                                //"errorMsg"=>"Votre Situation doit faire entre 2 et 100 caractères"
                            ]
                    ]
                ];
    }
    
    
}

