<?php

namespace PhpPlatform\Persist\Serialize\DataValueObjects;

use PhpPlatform\Errors\Exceptions\Application\BadInputException;
use PhpPlatform\Persist\Model;
use phpDocumentor\Reflection\Types\This;

class DVOArray {
	
	private $name = null;
	private $dvos = array();
	private $attributes = array();
	
	function __construct($name){
		if(!is_string($name)){
			throw new BadInputException("1st parameter should be string");
		}
		$this->name = $name;
	}
	
	function getName(){
		return $this->name;
	}
	
	function addModel($model){
		$dvo = new DVO($model);
		$this->dvos[] = $dvo;
		return $this;
	}
	
	function removeModel($index){
		$this->getModel($index); // test for existance of the model
		unset($this->dvos[$index]);
		return $this;
	}
	
	function getModel($index){
		if(is_int($index)){
			throw new BadInputException("1st parameter should be an integer");
		}
		if(count($this->dvos) <= $index){
			throw new BadInputException("no model at $index");
		}
		return $this->dvos[$index];
	}
	
	function getModels(){
		return $this->dvos;
	}
	
	function setAttribute($name,$value){
		if(!is_scalar($name) || is_bool($name)){
			throw new BadInputException("1st parameter should be either integer , real or string");
		}
		if(!is_scalar($value)){
			throw new BadInputException("1st parameter should be either integer , real , string or boolean");
		}
		
		$this->attributes[$name] = $value;
		return $this;
	}
	
	function removeAttribute($name){
		if(array_key_exists($name, $this->attributes)){
			unset($this->attributes[$name]);
		}
		return $this;
	}
	
	function getAttribute($name){
		if(array_key_exists($name, $this->attributes)){
			return $this->attributes[$name];
		}
		throw new BadInputException("attribute $name does not exist");
	}
	
	function getAttributes(){
		return array_merge(array(),$this->attributes);
	}
	
}