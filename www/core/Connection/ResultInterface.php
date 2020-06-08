<?php

namespace carsery\core\Connection;

//ResultInterface

interface ResultInterface
{
    public function getOneOrNullResult();
    public function getArrayResult();
    public function getValueResult();
}