<?php

namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Page;
use carsery\core\Helpers;

class PageManager extends DB {
    
    public function __construct()
    {
        parent::__construct(Page::class, 'page');
    }

    public function findByTitre($titre)
    {
        $table = $this->getTable();
        $sql = "SELECT * FROM $table WHERE titre =:titre";
        $results = $this->sql($sql,[':titre' => $titre]);
        $row = $results->fetch();

        if ($row) {
            $object = new $this->class;
            return $object->hydrate($row);
        }else {
            return null;
        }
    }

    public function findByPublic(bool $public)
    {
        $table = $this->getTable();
        $sql = "SELECT * FROM $table WHERE publie =:publie";
        $results = $this->sql($sql,[':publie' => $public]);
        $row = $results->fetch();

        if ($row) {
            $object = new $this->class;
            return $object->hydrate($row);
        }else {
            return null;
        }
    }

    public static function getPageForm(){
        return [
                    "config"=>[
                            "method"=>"POST",
                            "action"=>Helpers::getUrl("Page", "addPage"),
                            "class"=>"box",
                            "id"=>"formAddPage",
                            "submit"=>"Créer"
                    ],

                    "fields"=>[
                        "titre"=>[
                            "type"=>"text",
                            "placeholder"=>"Entrez un titre",
                            /* "class"=>"form-control form-control-user", */
                            "id"=>"id_titre",
                            "required"=>true,
                            "errorMsg"=>"Votre email n'est pas valide"
                        ],

                        "action"=>[
                            "type"=>"text",
                            "placeholder"=>"Quel est votre action",
                            /* "class"=>"form-control form-control-user", */
                            "id"=>"id_action",
                            "required"=>true,
                            "errorMsg"=>"Votre email n'est pas valide"
                        ],
                    ]
                ];
    }
}
