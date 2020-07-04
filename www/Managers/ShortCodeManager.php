<?php
namespace carsery\Managers;

use carsery\core\DB;
use carsery\models\Shortcode;

class ShortCodeManager extends DB {
    
    public function __construct()
    {
        parent::__construct(ShortCode::class, 'shortcode');
    }

    public function findByCode(string $code)
    {
        $table = $this->getTable();
        $connection = $this->getConnection();
        $sql = "SELECT * FROM $table WHERE shortcode = :shortcode";
        $result = $connection->query($sql, [':shortcode' => $code]);
        
        $row = $result->getOneOrNullResult();
        
        if ($row) {

            $object = new $this->class();
            return $object->hydrate($row);

        } else {

            return null;

        }
    }
    
}