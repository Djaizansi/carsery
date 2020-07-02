<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Category;
use carsery\core\Helpers;

class CategoryManager extends DB{
    public function __construct()
    {
        parent::__construct(Category::class, 'category');
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

    public static function getCategoryForm(){
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("Category", "ajout-category"),
                "class"=>"box",
                "id"=>"formAddCategory",
                "submit"=>"Ajouter"
            ],

            "fields"=>[
                "name"=>[
                    "type"=>"text",
                    "placeholder"=>"Nom",
                    /* "class"=>"form-control form-control-user", */
                    "id"=>"",
                    "required"=>true,
                    "uniq"=>["table"=>"category", "column"=>"name"],
                    "errorMsg"=>"Veuillez renseigner un nom de catégorie"
                ]

                
            ]
        ];
    }
}