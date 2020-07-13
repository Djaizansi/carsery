<?php

namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Theme;

class ThemeManager extends DB {
    
    public function __construct()
    {
        parent::__construct(Theme::class, 'themes');
    }
    
    public function findByThemeId($id)
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
}