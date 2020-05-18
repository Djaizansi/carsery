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
        $sql = "SELECT * FROM $table WHERE email = :email";
        $result = $this->sql($sql, [':email' => $email]);
        
        $row = $result->fetch();
        
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
        $sql = "SELECT * FROM $table WHERE id = :id";
        $result = $this->sql($sql, [':id' => $id]);
        
        $row = $result->fetch();
        
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
                                        "type"=>"email",
                                        "placeholder"=>"Votre email",
                                        /* "class"=>"form-control form-control-user", */
                                        "id"=>"",
                                        "required"=>true,
                                        "uniq"=>["table"=>"users", "column"=>"email"],
                                        "errorMsg"=>"Votre email ne correspond pas"
                                ],
                                "pwd"=>[
                                        "type"=>"password",
                                        "placeholder"=>"Votre mot de passe",
                                        /* "class"=>"form-control form-control-user", */
                                        "id"=>"",
                                        "required"=>true,
                                        "errorMsg"=>"Votre mot de passe doit être compris entre 6 et 16 caractères 
                                        avec une Majuscule et Minuscule"
                                ],
                                "pwdConfirm"=>[
                                        "type"=>"password",
                                        "placeholder"=>"Confirmation",
                                        /* "class"=>"form-control form-control-user", */
                                        "id"=>"idPwdConfirm",
                                        "required"=>true,
                                        "confirmWiths"=>"pwd",
                                        "errorMsg"=>"Votre mot de passe de confirmation ne correspond pas"
                                ],
                                "captcha"=>[
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
                            "type"=>"email",
                            "placeholder"=>"Email",
                            /* "class"=>"form-control form-control-user", */
                            "id"=>"",
                            "required"=>true,
                            "uniq"=>["table"=>"users", "column"=>"email"],
                            "errorMsg"=>"Votre email n'existe pas"
                        ],

                        "pwd"=>[
                            "type"=>"password",
                            "placeholder"=>"Password",
                            /* "class"=>"form-control form-control-user", */
                            "id"=>"",
                            "required"=>true,
                            "errorMsg"=>"Votre mot de passe n'est pas correcte"
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