<?php

namespace carsery\core\Connection;

//Interface

interface BDDInterface
{
    public function connect();

    public function query(string $query, array $parameters = null);
}