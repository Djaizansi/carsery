<?php 

namespace carsery\models;

use JsonSerializable;

class Json implements JsonSerializable {
    
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function jsonSerialize()
    {
        return $this->array;
    }

    public function initRelation(): array {
        return [
        
        ];
    }

}