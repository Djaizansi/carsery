<?php

namespace carsery\core\Connection;

use Throwable;

//PDOResult

class PDOResult implements ResultInterface
{
    protected $statement;

    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    public function getOneOrNullResult()
    {
        try{
            return $this->statement->fetch();
        }catch(Throwable $t){
            echo $t->getMessage();
        }

    }

    public function getArrayResult()
    {
        return $this->statement->fetchAll();
    }

    public function getValueResult()
    {
        return $this->statement->fetchColumn();
    }
}