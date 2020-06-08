<?php

namespace carsery\core\Exceptions;

use Exception;
use Throwable;

interface MyThrowable extends Throwable
{}

class BDDException extends Exception implements MyThrowable {
    public function __construct($message, $code = 0)
    {
        parent::__construct($message,$code);
    }

    public function __toString()
    {
        return $this->message;
    }
}