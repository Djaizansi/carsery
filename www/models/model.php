<?php

namespace models;

class model {


public function hydrate(array $donnees){
        foreach ( $donnees as $key => $value) {
        $getDonnees = 'set'.$key;
        echo $key.$donnees;
        if (method_exists($this, $getDonnees)) {$this->$getDonnees($value);}
    }
} 


}