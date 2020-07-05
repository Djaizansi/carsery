<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Article;
use carsery\core\Helpers;

class ArticleManager extends DB
{
    public function __construct()
    {
        parent::__construct(Article::class, 'article');
    }

    public function findAll(): array
    {
        $sql = "SELECT a.* FROM ". parent::getTable()." a
                INNER JOIN ymnw_users u ON u.id = a.author
                INNER JOIN ymnw_category c ON c.id = a.category";
        $result = $this->getConnection()->query($sql);
        $rows = $result->getArrayResult();
        $find = [];
        foreach ($rows as $row) {
            $object = new $this->class();
            try {
                array_push($find, $object->hydrate($row));
            } catch (BDDException $e) {
                die($e->getMessage());
            }
        }

        return $find;
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

    /**
     * Formulaire d'ajout et de modification d'article
     * @param null $article
     * @return array
     */
    public static function getArticleForm($article = null)
    {

        $action = (isset($article)) ? helpers::getUrl("Forum", "updatearticle") : helpers::getUrl("Forum", "addarticle");
        $submit = (isset($article)) ? 'Modifier' : 'Ajouter';
        $titleValue = (isset($article)) ? ["value" => $article->getTitle()] : [];
        $descValue = (isset($article)) ? ["value" => $article->getDescription()] : [];
        $catValue = (isset($article)) ? ["value" => $article->getCategory()->getId()] : [];
        $idValue = (isset($article)) ? ["id" => ["value" => $article->getId(), "type" => "hidden"]] : [];

        return [
            "config" => [
                "method" => "POST",
                "action" => $action,
                "class" => "box",
                "id" => "formAddArticle",
                "submit" => $submit
            ],

            "fields" => array_merge([
                // Si formulaire de modification ajout de la valeur du titre
                "titre" => array_merge([
                    "type" => "text",
                    "placeholder" => "Titre",
                    /* "class"=>"form-control form-control-user", */
                    "id" => "",
                    "required" => true,
                    "uniq" => ["table" => "article", "column" => "title"],
                    "min-lenght" => 2,
                    "max-lenght" => 100,
                    "value" => "",
                    "errorMsg" => "Veuillez renseigner un titre"
                ], $titleValue),

                "description" => array_merge([
                    "balise" => "textarea",
                    "type" => "text",
                    "placeholder" => "Description",
                    "id" => "",
                    "class" => "box",
                    "required" => true,
                    "min-lenght" => 2,
                    "value" => "",
                    "errorMsg" => "Veuillez renseigner une description"
                ], $descValue),

                "categorie" => array_merge([
                    "type" => "relation",
                    "placeholder" => "Choisir une Categorie",
                    "id" => "",
                    "class" => "box",
                    "required" => true,
                    "values" => "",
                    "value" => "",
                    "errorMsg" => "Veuillez renseigner une catégorie"
                ], $catValue)


            ], $idValue)
        ];
    }
}