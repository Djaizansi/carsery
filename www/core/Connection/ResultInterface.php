<?php

namespace carsery\core\Connection;

interface ResultInterface
{
    public function getOneOrNullResult();
    public function getArrayResult();
    public function getValueResult();
}