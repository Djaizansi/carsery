<?php

namespace carsery\models;

use carsery\core\Exceptions\BDDException;

interface iModel {
    public function hydrate(array $row);
}

class Model implements iModel
{
    public function __toArray(): array
    {
        return get_object_vars($this);
    }

    public function hydrate(array $row)
    {
        $className = get_class($this);// $className = static::class
        $articleObj = new $className();
        foreach ($row as $key => $value) {

            $method = 'set'.str_replace('_', '', ucwords($key, '_'));
            if (method_exists($articleObj, $method)) {
                // Author = 4
                if($relation = $articleObj->getRelation($key)) {
                    // relation = User::class (App\Model\User)
                    $tmp = new $relation();
                    $tmp = $tmp->hydrate($row);
                    // Maintenant on récupère notre id qui est ... la valeur actuelle de notre objet
                    $tmp->setId($value);
                    $articleObj->$method($tmp);
                } else {
                    $articleObj->$method($value);
                }
            }
        }

        return $articleObj;
    }

    public function getRelation(string $key): ?string
    {
        $relations = $this->initRelation();

        if(isset($relations[$key]))
            return $this->initRelation()[$key];

        return null;
    }


}
