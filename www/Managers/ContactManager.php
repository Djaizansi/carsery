<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Contact;
use carsery\core\Helpers; 

class ContactManager extends DB {
    
    public function __construct()
    {
        parent::__construct(Contact::class, 'contact');
    }

    public static function addData($contact,$contactManager,$id = '', $nom,$adresse)
    {
        empty($id) ? '' : $contact->setId($id);
        $contact->setNom($nom);
        $contact->setAdresse($adresse);
        $contactManager->save($contact);
    }

    public function findByNom($nom)
    {
        $table = $this->getTable();
        $connection = $this->getConnection();
        $sql = "SELECT * FROM $table WHERE nom =:nom";
        $results = $connection->query($sql,[':nom' => $nom]);
        $row = $results->getOneOrNullResult();

        if ($row) {
            $object = new $this->class;
            return $object->hydrate($row);
        }else {
            return null;
        }
    }


    public static function getContactForm(){
        return [
                    "config"=>[
                            "method"=>"POST",
                            "action"=>Helpers::getUrl("Contact", "addContact"),
                            "class"=>"box",
                            "id"=>"formAddContact",
                            "submit"=>"Créer"
                    ],

                    "fields"=>[
                        "id"=>[
                            "balise"=>"",
                            "type"=>"hidden",
                            "id"=>"id",
                            "required"=>true,
                        ],
                        "nom"=>[
                                "balise"=>"",
                                "type"=>"text",
                                "placeholder"=>"Votre nom d'adresse",
                                "required"=>true,
                                "min-lenght"=>2,
                                "max-lenght"=>255,
                                "errorMsg"=>"Votre nom doit faire entre 2 et 255 caractères"
                        ],
                        "adresse"=>[
                                "balise"=>"",
                                "type"=>"text",
                                "placeholder"=>"Votre adresse",
                                "required"=>true,
                                "min-length"=>2,
                                "max-length"=>255,
                                "errorMsg"=>"Votre adresse doit faire entre 2 et 255 caractères"
                        ],
                ]
                ];
    }
    public static function getUpdateForm(){
        return [
                "config"=>[
                            "method"=>"POST",
                            "action"=>Helpers::getUrl("Contact", "updateContact"),
                            "class"=>"box",
                            "id"=>"jqueryForm",
                            "submit"=>"Modifier"
                ],
                "fields"=>[
                            "id"=>[
                                "balise"=>"",
                                "type"=>"hidden",
                                "id"=>"id",
                                "required"=>true,
                            ],
                            "nom"=>[
                                    "balise"=>"",
                                    "type"=>"text",
                                    "placeholder"=>"Votre nom d'adresse",
                                    "required"=>true,
                                    "min-lenght"=>2,
                                    "max-lenght"=>255,
                                    "errorMsg"=>"Votre nom doit faire entre 2 et 255 caractères"
                            ],
                            "adresse"=>[
                                    "balise"=>"",
                                    "type"=>"text",
                                    "placeholder"=>"Votre adresse",
                                    "required"=>true,
                                    "min-length"=>2,
                                    "max-length"=>255,
                                    "errorMsg"=>"Votre adresse doit faire entre 2 et 255 caractères"
                            ],
                    ]
            ];
    }

}
