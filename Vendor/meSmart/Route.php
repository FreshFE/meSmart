<?php
namespace meSmart;

use meSmart;

class Route {

	protected static $mapping = array();

	protected static $name = array();

	protected static $path = array();

	protected static $class = 'meSmart\\Routes\\Restful';

	public static function parse()
	{
		$class = static::$class;
		
		$route = new $class();
		$route->parse();


		// return array(
		// 	'app' => '',
		// 	'group' => '',
		// 	'controller' => '',
		// 	'method' => ''
		// );
	}

	public static function get($name, $type)
	{
		if($type == 'name') {
			$value = static::$name;	
		}
		else if($type == 'type') {
			$value = static::$path;
		}
		
		return isset($value[$name]) ? $value[$name] : null;
	}

	public static function name($name)
	{
		return static::get($name, 'name');
	}

	public static function path($name)
	{
		return static::get($name, 'path');
	}
}