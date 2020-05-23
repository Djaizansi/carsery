<?php

namespace Carsery\Managers;

class VehiculeManager extends DB{


	public function __construct(){

		parent::__construct(vehicules::class,'vehicules');
	}
}

