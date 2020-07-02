<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Article;
use carsery\core\Helpers;

class ArticleManager extends DB{
    public function __construct()
    {
        parent::__construct(Article::class, 'article');
    }

    public function findById($id)
    {
        $table = $this->getTable();
        $connection = $this->getConnection();
        $sql = "SELECT * FROM $table WHERE id = :id";
        $result = $connection->query($sql, [':id' => $id]);
        
        $row = $result->getOneOrNullResult();
        
        if ($row) {

            $object = new $this->class();
            return $object->hydrate($row);

        } else {

            return null;

        }
    }

    public static function getArticleForm(){
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("Forum", "addarticle"),
                "class"=>"box",
                "id"=>"formAddArticle",
                "submit"=>"Ajouter"
            ],

            "fields"=>[
                "titre"=>[
                    "type"=>"text",
                    "placeholder"=>"Titre",
                    /* "class"=>"form-control form-control-user", */
                    "id"=>"",
                    "required"=>true,
                    "uniq"=>["table"=>"article", "column"=>"title"],
                    "min-lenght"=>2,
                    "max-lenght"=>100,
                    "errorMsg"=>"Veuillez renseigner un titre"
                ],

                "description"=>[
                    "balise"=>"textarea",
                    "type" => "text",
                    "placeholder"=>"Description",
                    "id"=>"",
                    "class"=>"box",
                    "required"=>true,
                    "min-lenght"=>2,
                    "errorMsg"=>"Veuillez renseigner une description"
                ],

                "categorie"=>[
                    "type" => "relation",
                    "placeholder" => "Choisir une Categorie",
                    "id"=>"",
                    "class"=>"box",
                    "required"=>true,
                    "value"=> "",
                    "errorMsg"=>"Veuillez renseigner une catégorie"
                ]

                
            ]
        ];
    }
}