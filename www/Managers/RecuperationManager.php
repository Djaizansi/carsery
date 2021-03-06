<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Recuperation;
use carsery\core\Helpers;

class RecuperationManager extends DB {
    
    public function __construct()
    {
        parent::__construct(Recuperation::class, 'recuperation');
    }

    public function findByEmail($email)
    {
        $table = $this->getTable();
        $connection = $this->getConnection();
        $sql = "SELECT * FROM $table WHERE mail = :mail";
        $results = $connection->query($sql,[":mail" => $email]);
        $row = $results->getOneOrNullResult();
        
        if ($row) {
            $object = new $this->class;
            return $object->hydrate($row);
        }else {
            return null;
        }
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

    public static function getCodeForm(){
        return [
            "config"=>[
                    "method"=>"POST",
                    "action"=>helpers::getUrl("User", "recupcode"),
                    "class"=>"box",
                    "id"=>"formCodeRecup",
                    "submit"=>"Valider"
            ],

            "fields"=>[
                "code"=>[
                    "balise"=>"",
                    "type"=>"text",
                    "placeholder"=>"Code de vérification",
                    /* "class"=>"form-control form-control-user", */
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Code incorrect"
                ]
            ]
        ];
    }

    public static function getPwdForm(){
        return [
            "config"=>[
                    "method"=>"POST",
                    "action"=>helpers::getUrl("User", "changemdp"),
                    "class"=>"box",
                    "id"=>"formPwdChange",
                    "submit"=>"Valider"
            ],

            "fields"=>[
                "pwd"=>[
                    "balise"=>"",
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe",
                    /* "class"=>"form-control form-control-user", */
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Votre mot de passe doit être compris entre 6 et 16 caractères 
                    avec une Majuscule et Minuscule"
                ],
                "pwdConfirm"=>[
                    "balise"=>"",
                    "type"=>"password",
                    "placeholder"=>"Confirmation",
                    /* "class"=>"form-control form-control-user", */
                    "id"=>"idPwdConfirm",
                    "required"=>true,
                    "confirmWiths"=>"pwd",
                    "errorMsg"=>"Votre mot de passe de confirmation ne correspond pas"
                ]
            ]
        ];
    }
}
