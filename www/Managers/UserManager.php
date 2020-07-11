<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\User;
use carsery\core\Helpers;

class UserManager extends DB {
    
    public function __construct()
    {
        parent::__construct(User::class, 'users');
    }

    public function findByEmail($email)
    {
        $table = $this->getTable();
        $connection = $this->getConnection();
        $sql = "SELECT * FROM $table WHERE email = :email";
        $result = $connection->query($sql, [':email' => $email]);
        
        $row = $result->getOneOrNullResult();
        
        if ($row) {

            $object = new $this->class();
            return $object->hydrate($row);

        } else {

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

    public static function getRegisterForm(){
        return [
                    "config"=>[
                                "method"=>"POST",
                                "action"=>Helpers::getUrl("user", "register"),
                                "class"=>"box",
                                "id"=>"formRegisterUser",
                                "submit"=>"S'inscrire"
                            ],
                    "fields"=>[
                                "lastname"=>[
                                        "balise"=>"",
                                        "type"=>"text",
                                        "placeholder"=>"Votre nom",
                                        /* "class"=>"form-control form-control-user", */
                                        "id"=>"",
                                        "required"=>true,
                                        "min-lenght"=>2,
                                        "max-lenght"=>100,
                                        "errorMsg"=>"Votre nom doit faire entre 2 et 100 caractères"
                                ],
                                "firstname"=>[
                                        "balise"=>"",
                                        "type"=>"text",
                                        "placeholder"=>"Votre prénom",
                                        /* "class"=>"form-control form-control-user", */
                                        "id"=>"",
                                        "required"=>true,
                                        "min-lenght"=>2,
                                        "max-lenght"=>50,
                                        "errorMsg"=>"Votre prenom doit faire entre 2 et 50 caractères"
                                ],
                                "email"=>[
                                        "balise"=>"",
                                        "type"=>"email",
                                        "placeholder"=>"Votre email",
                                        /* "class"=>"form-control form-control-user", */
                                        "id"=>"",
                                        "required"=>true,
                                        "uniq"=>["table"=>"users", "column"=>"email"],
                                        "errorMsg"=>"Votre email ne correspond pas"
                                ],
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
                                ],
                                "captcha"=>[
                                        "balise"=>"",
                                        "type"=>"captcha",
                                        /* "class"=>"form-control form-control-user", */
                                        "id"=>"",
                                        "required"=>true,
                                        "placeholder"=>"Veuillez saisir les caractères",
                                        "errorMsg"=>"Le captcha est incorrect"
                                ]


                    ]

                ];
    }

    public static function getLoginForm(){
        return [
                    "config"=>[
                            "method"=>"POST",
                            "action"=>Helpers::getUrl("User", "login"),
                            "class"=>"box",
                            "id"=>"formLoginUser",
                            "submit"=>"Se connecter"
                    ],

                    "fields"=>[
                        "email"=>[
                            "balise"=>"",
                            "type"=>"email",
                            "placeholder"=>"Email",
                            "id"=>"",
                            "required"=>true,
                            "uniq"=>["table"=>"users", "column"=>"email"],
                            "errorMsg"=>"Votre email n'existe pas"
                        ],

                        "pwd"=>[
                            "balise"=>"",
                            "type"=>"password",
                            "placeholder"=>"Password",
                            "id"=>"",
                            "required"=>true,
                            "errorMsg"=>"Votre mot de passe n'est pas correcte"
                        ]
                    ]
                ];
    }

    public static function getUpdateForm(){
        return [
                "config"=>[
                            "method"=>"POST",
                            "action"=>Helpers::getUrl("User", "updateUser"),
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
                            "lastname"=>[
                                    "balise"=>"",
                                    "type"=>"text",
                                    "placeholder"=>"Votre nom",
                                    "id"=>"id_lastname",
                                    "required"=>true,
                                    "min-lenght"=>2,
                                    "max-lenght"=>100,
                                    "errorMsg"=>"Votre nom doit faire entre 2 et 100 caractères"
                            ],
                            "firstname"=>[
                                    "balise"=>"",
                                    "type"=>"text",
                                    "placeholder"=>"Votre prénom",
                                    "id"=>"id_firstname",
                                    "required"=>true,
                                    "min-lenght"=>2,
                                    "max-lenght"=>50,
                                    "errorMsg"=>"Votre prenom doit faire entre 2 et 50 caractères"
                            ],
                            "email"=>[
                                    "balise"=>"",
                                    "type"=>"email",
                                    "placeholder"=>"Votre email",
                                    "id"=>"id_email",
                                    "required"=>true,
                                    "uniq"=>["table"=>"users", "column"=>"email"],
                                    "errorMsg"=>"Votre email ne correspond pas"
                            ],
                            "status"=>[
                                "balise"=>"select",
                                "type"=>"text",
                                "placeholder"=>"Votre rôle",
                                "id"=>"id_role",
                                "required"=>true
                            ]
                    ]
            ];
    }

    public static function getMdpForm(){
        return [
                    "config"=>[
                            "method"=>"POST",
                            "action"=>Helpers::getUrl("User", "forget"),
                            "class"=>"box",
                            "id"=>"formLoginUser",
                            "submit"=>"Envoyer"
                    ],

                    "fields"=>[
                        "email"=>[
                            "balise"=>"",
                            "type"=>"email",
                            "placeholder"=>"Email",
                            /* "class"=>"form-control form-control-user", */
                            "id"=>"",
                            "required"=>true,
                            "uniq"=>["table"=>"users", "column"=>"email"],
                            "errorMsg"=>"Votre email n'est pas valide"
                        ]
                    ]
                ];
    }
}