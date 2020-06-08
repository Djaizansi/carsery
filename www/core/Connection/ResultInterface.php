<?php

namespace carsery\core\Connection;

interface ResultInterface
{
    public function getOneOrNullResult();
    public function getArrayResult();
    public function getArrayResultTp(string $model); //Ajout de la fonction afin d'obliger d'appeller cette dernière et ne pas faire d'erreur
    public function getValueResult();
}