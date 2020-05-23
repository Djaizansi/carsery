<?php

namespace Carsery\Core;

class JsonObject implements JsonSerializable {

	//protected $array = new array();

	public function __construct(array $array){

		$this->array = $array;
		//$this->jsonSerialize();
	}

	public function jsonSerialize(){

		return $this->array;
	}
}
