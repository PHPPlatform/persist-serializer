<?php

namespace PhpPlatform\Persist\Serialize\DataValueObjects;

use PhpPlatform\Persist\Model;
use PhpPlatform\Errors\Exceptions\Application\BadInputException;

class DVO {
	
	private $model = null;
	private $attributes = array();
	
	/**
	 * @param Model|DVO $model
	 */
	function __construct($model){
		if($model instanceof Model){
			$this->model = $model;
		}else if($model instanceof DVO){
			$this->model = $model->model;
			$this->attributes = array_merge(array(),$model->attributes);
		}else{
			throw new BadInputException('1st parameter should be an instance of PhpPlatform\Persist\Model or '.get_class());
		}
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
	
	function getModel(){
		return $this->model;
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