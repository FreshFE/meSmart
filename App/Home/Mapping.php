<?php
namespace App\Home;
/**
 * Project app config
 * Copyright (c) 2004-2013 Methink
 * minowu@foxmail.com
 */

use meSmart;

/**
 * App group config
 */
class Mapping extends meSmart\Mapping {

	// public static $event_before = array(
	// 	'route' => 'route_array'
	// );

	public static function route_array()
	{
		dump('route_array');
	}
}