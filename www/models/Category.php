<?php

namespace carsery\models;

use carsery\models\Model;
use carsery\core\Helpers;

class Category extends Model{

	protected $id;
	protected $name;

    public function initRelation(): array {
        return [
        
        ];
    }

    public function setId($id)
    {
        $this->id=$id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name=$name;
    }

    public function getName()
    {
        return $this->name;
    }
}