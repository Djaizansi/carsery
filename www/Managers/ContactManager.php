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
        empty($id) ? '' : $page->setId($id);
        $page->setNom($nom);
        $page->setAdresse($adresse);
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
                        "adresse"=>[
                            "balise"=>"",
                            "type"=>"text",
                            "placeholder"=>"Entrez une adresse",
                            /* "class"=>"form-control form-control-user", */
                            "id"=>"id_adresse",
                            "required"=>true,
                            "errorMsg"=>""
                        ],
                    ]
                ];
    }
}
