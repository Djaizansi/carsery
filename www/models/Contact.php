<?php
class Contact extends Model{
  
    var $validate = array(
        'nom' => array(
            'rule' => 'notEmpty',
            'message' => 'Veuillez écrire votre nom'
        ),
        'email' => array(
            'rule' => '([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9]+)*)',
            'message' => 'Saisissez une adresse mail valide'
        ),
        'content' => array(
            'rule' => 'notEmpty',
            'message' => 'Saisissez un message'
        )
    );
 
  
}