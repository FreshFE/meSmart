<?php
namespace meSmart;
/**
 * meSmart php
 * Copyright (c) 2004-2013 Methink
 * @copyright     Copyright (c) Methink
 * @link          https://github.com/minowu/meSmart
 * @package       meSmart
 * @since         meSmart php 0.1.0
 * @license       Apache License (http://www.apache.org/licenses/LICENSE-2.0)
 */

/*
 * 存储，修改，覆盖，获取配置信息的类
 * 该类分为两部分
 * 一部分为动态类部分用于设置默认配置，被App & group config继承
 * 另一部分为静态类，专门用于获取Smart::$config的配置信息
 * Smart::$config是在Smart类中被定义，指向实例化后的Group config
 */
class Config {

	// -------------------------------------------
	// 类动态部分，用于被App & group config覆盖
	// -------------------------------------------

	/**
	 * 默认配置项
	 * 将默认需配置的项目写在这个数组里面，可以由App & group config覆盖
	 *
	 * @var array
	 */
	public $default_timezone = 'Asia/Shanghai';

	public $output_encode = true;

	public $var_filters = 'filter_exp';


	// -------------------------------------------
	// 类静态方法部分，用于操作Smart::$config内数据
	// -------------------------------------------

	/**
	 * 静态方法，供外部类使用
	 * 可以通过Config::get的方式来获取Smart::$config内的数据
	 * 避免重复实例化
	 *
	 * @param string $name
	 * @return mixed
	 */
	public static function get($name) {

		$config = Smart::$config;

		if(is_null($name)) {
			return $config;
		}
		else {
			return $config->$name;	
		}
	}

	/**
	 * 静态方法，供外部类使用
	 * 可以通过Config::set的方式来设置Smart::$config内的数据
	 * 避免重复实例化
	 *
	 * @param string $name
	 * @return mixed
	 */
	public static function set($name, $value) {

		$config = Smart::$config;

		if(is_array($name)) {
			foreach ($name as $key => $value) {
				$config->$key = $value;
			}

			return $name;
		}
		else {
			return $config->$name = $value;
		}
	}
}