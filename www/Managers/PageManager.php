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

    public static function addData($page,$pageManager,$id = '', $titre,$auteur,$content,$date='',$publie,$uri,$menu,$home,$token = NULL)
    {
        empty($id) ? '' : $page->setId($id);
        isset($titre) ? $page->setTitre($titre) : '';
        $page->setAuteur($auteur);
        $page->setContent($content);
        !empty($id) && !empty($date) ? $page->setDate($date) : $page->setDate(date('Y-m-d H:i'));
        $page->setPublie($publie);
        $page->setUri($uri);
        $page->setMenu($menu);
        $page->setHome($home);
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

    public function findByUri($uri)
    {
        $table = $this->getTable();
        $connection = $this->getConnection();
        $sql = "SELECT * FROM $table WHERE uri =:uri";
        $results = $connection->query($sql,[':uri' => $uri]);
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
                            "id"=>"id_titre",
                            "required"=>true,
                            "errorMsg"=>""
                        ],

                        "checkbox"=>[
                            "balise"=>"",
                            "type"=>"checkbox",
                            "id"=>"id_checkbox",
                            "value"=>"yes"
                        ],

                        "public"=>[
                            "balise"=>"",
                            "type"=>"checkbox",
                            "id"=>"id_checkbox_public",
                            "value"=>"yes"
                        ],

                        "home"=>[
                            "balise"=>"",
                            "type"=>"checkbox",
                            "id"=>"id_checkbox_home",
                            "value"=>"yes"
                        ]
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
                        ],
                        "checkbox"=>[
                            "balise"=>"",
                            "type"=>"checkbox",
                            "id"=>"id_checkbox",
                            "value"=>"yes"
                        ],

                        "public"=>[
                            "balise"=>"",
                            "type"=>"checkbox",
                            "id"=>"id_checkbox_public",
                            "value"=>"yes"
                        ],
                        
                        "home"=>[
                            "balise"=>"",
                            "type"=>"checkbox",
                            "id"=>"id_checkbox_home",
                            "value"=>"yes"
                        ]
                    ]
                ];
    }
}
