<?php

namespace carsery\Managers;


use carsery\core\DB;
use carsery\core\Helpers;
use carsery\models\Message;

class MessageManager extends DB
{
    public function __construct()
    {
        parent::__construct(Message::class, 'message');
    }

    /**
     * Formulaire d'ajout et de modification des messages
     * @param null $message
     * @return array
     */
    public static function getMessageForm($message = null)
    {

        $action = (isset($message)) ? helpers::getUrl("Forum", "updatemessagearticle") : helpers::getUrl("Forum", "addmessagearticle");
        $submit = (isset($message)) ? 'Modifier' : 'Ajouter';
        $messValue = (isset($message)) ? ["value" => $message->getMessage()] : [];
        $idValue = (isset($message)) ? ["id" => ["value" => $message->getId(), "type" => "hidden"]] : [];

        return [
            "config" => [
                "method" => "POST",
                "action" => $action,
                "class" => "box",
                "id" => "formAddMessage",
                "submit" => $submit
            ],

            "fields" => array_merge([
                "message" => array_merge([
                    "balise" => "textarea",
                    "type" => "text",
                    "placeholder" => "Message",
                    "id" => "",
                    "class" => "box",
                    "required" => true,
                    "min-lenght" => 2,
                    "value" => "",
                    "errorMsg" => "Veuillez renseigner un message"
                ], $messValue),
            ], $idValue)
        ];
    }


    public static function getFrontMessageForm($message = null)
    {

        $action = (isset($message)) ? helpers::getUrl("Front", "updatemessage") : helpers::getUrl("Front", "addmessage");
        $submit = (isset($message)) ? 'Modifier' : 'Ajouter';
        $messValue = (isset($message)) ? ["value" => $message->getMessage()] : [];
        $idValue = (isset($message)) ? ["id" => ["value" => $message->getId(), "type" => "hidden"]] : [];

        return [
            "config" => [
                "method" => "POST",
                "action" => $action,
                "class" => "box",
                "id" => "formAddMessage",
                "submit" => $submit
            ],

            "fields" => array_merge([
                "message" => array_merge([
                    "balise" => "textarea",
                    "type" => "text",
                    "placeholder" => "Message",
                    "id" => "",
                    "class" => "box",
                    "required" => true,
                    "min-lenght" => 2,
                    "value" => "",
                    "errorMsg" => "Veuillez renseigner un message"
                ], $messValue),
            ], $idValue)
        ];
    }


}