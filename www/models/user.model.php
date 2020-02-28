<?php
class user extends DB
{
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $pwd;
    protected $status;

    /* public function hydrate(array $columnTable)
    {
        foreach ($columnTable as $key => $value)
        {
        // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
        
        // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
        // On appelle le setter.
                $this->$method($value);
            }
        }
    } */
    
    public function __construct()
    {
        parent::__construct();
    }

    public function setId($id)
    {
        $this->id=$id;
    }
    public function setFirstname($firstname)
    {
        $this->firstname=ucwords(strtolower(trim($firstname)));
    }
    public function setLastname($lastname)
    {
        $this->lastname=strtoupper(trim($lastname));
    }
    public function setEmail($email)
    {
        $this->email=strtolower(trim($email));
    }
    public function setPwd($pwd)
    {
        $this->pwd=$pwd;
    }
    public function setStatus($status)
    {
        $this->status=$status;
    }
    public static function getRegisterForm(){
        return [
                    "config"=>[
                                "method"=>"POST",
                                "action"=>helpers::getUrl("user", "register"),
                                "class"=>"user",
                                "id"=>"formRegisterUser",
                                "submit"=>"S'inscrire"
                            ],
                    "fields"=>[
                                "firstname"=>[
                                        "type"=>"text",
                                        "placeholder"=>"Votre prénom",
                                        "class"=>"form-control form-control-user",
                                        "id"=>"",
                                        "required"=>true,
                                        "min-lenght"=>2,
                                        "max-lenght"=>50,
                                        "errorMsg"=>"Votre prenom doit faire entre 2 et 50 caractères"
                                ],
                                "lastname"=>[
                                        "type"=>"text",
                                        "placeholder"=>"Votre nom",
                                        "class"=>"form-control form-control-user",
                                        "id"=>"",
                                        "required"=>true,
                                        "min-lenght"=>2,
                                        "max-lenght"=>100,
                                        "errorMsg"=>"Votre nom doit faire entre 2 et 100 caractères"
                                ],
                                "email"=>[
                                        "type"=>"email",
                                        "placeholder"=>"Votre email",
                                        "class"=>"form-control form-control-user",
                                        "id"=>"",
                                        "required"=>true,
                                        "uniq"=>["table"=>"users", "column"=>"email"],
                                        "errorMsg"=>"Votre email ne correspond pas"

                                ],
                                "pwd"=>[
                                        "type"=>"password",
                                        "placeholder"=>"Votre mot de passe",
                                        "class"=>"form-control form-control-user",
                                        "id"=>"",
                                        "required"=>true,
                                        "errorMsg"=>"Votre mot de passe doit être compris entre 6 et 20 caractères 
                                        avec une Majuscule et Minuscule"
                                ],
                                "pwdConfirm"=>[
                                        "type"=>"password",
                                        "placeholder"=>"Confirmation",
                                        "class"=>"form-control form-control-user",
                                        "id"=>"",
                                        "required"=>true,
                                        "confirmWiths"=>"pwd",
                                        "errorMsg"=>"Votre mot de passe de confirmation ne correspond pas"
                                ],
                                "captcha"=>[
                                        "type"=>"captcha",
                                        "class"=>"form-control form-control-user",
                                        "id"=>"",
                                        "placeholder"=>"Veuillez saisir les caractères",
                                        "errorMsg"=>"Le captcha est incorrect"

                                ]


                    ]

                ];
    }

    public static function getLoginForm(){
        return [
                    
                ];
    }
}
