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

    public static function addData($page,$pageManager,$id = '', $titre,$auteur,$publie,$action,$token = NULL)
    {
        empty($id) ? '' : $page->setId($id);
        isset($titre) ? $page->setTitre($titre) : '';
        $page->setAuteur($auteur);
        $page->setDate(date('Y-m-d H:i'));
        $page->setPublie($publie);
        isset($action) ? $page->setAction($action) : '';
        $page->setToken($token);
        $pageManager->save($page);
    }

    public function findByTitre($titre)
    {
        $table = $this->getTable();
        $connection = $this->getConnection();
        $sql = "SELECT * FROM $table WHERE titre =:titre";
        $results = $connection->query($sql,[':titre' => $titre]);
        $row = $results->getOneOrNullResult();

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
        $connection = $this->getConnection();
        $sql = "SELECT * FROM $table WHERE publie =:publie";
        $results = $connection->query($sql,[':publie' => $public]);
        $row = $results->getOneOrNullResult();

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
                            "balise"=>"",
                            "type"=>"text",
                            "placeholder"=>"Entrez un titre",
                            /* "class"=>"form-control form-control-user", */
                            "id"=>"id_titre",
                            "required"=>true,
                            "errorMsg"=>"Votre email n'est pas valide"
                        ],

                        "action"=>[
                            "balise"=>"",
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

    public static function getWYSIWYGForm(){
        return [
                    "config"=>[
                            "method"=>"POST",
                            "action"=>"",
                            "class"=>"box",
                            "id"=>"formAddPage",
                            "submit"=>"Créer"
                    ],

                    "fields"=>[
                        "editPage"=>[
                            "balise"=>"textarea",
                            "type" => "text",
                            "id"=>"myTextarea",
                            "placeholder"=>""
                        ]
                    ]
                ];
    }
}
