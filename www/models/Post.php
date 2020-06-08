<?php

namespace carsery\models;

use carsery\models\Model;
use carsery\models\User;

class Post extends Model
{
    protected $id;
    protected $title;
    protected $author;


    public function initRelation(): array { // Relation post / user
        return [
            'author' => User::class
        ];
    }
}