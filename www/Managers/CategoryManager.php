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

    public static function getCategoryForm($category=null){

        $action = (isset($category)) ? helpers::getUrl("Forum", "updatecategory") : helpers::getUrl("Forum", "addcategory");
        $submit = (isset($category)) ? 'Modifier' : 'Ajouter';
        $nameValue = (isset($category)) ? ["value" => $category->getName()] : [];
        $idValue = (isset($category)) ? ["id" => ["value" => $category->getId(), "type" => "hidden"]] : [];

        return [
            "config"=>[
                "method"=>"POST",
                "action"=>$action,
                "class"=>"box",
                "id"=>"formAddCategory",
                "submit"=>$submit
            ],

            "fields"=>array_merge([
                "name"=> array_merge([
                    "type"=>"text",
                    "placeholder"=>"Nom",
                    "min-lenght" => 2,
                    "max-lenght" => 50,
                    "id"=>"",
                    "required"=>true,
                    "uniq"=>["table"=>"category", "column"=>"name"],
                    "errorMsg"=>"Veuillez renseigner un nom de catégorie"
                ], $nameValue)
            ], $idValue)
        ];
    }
}