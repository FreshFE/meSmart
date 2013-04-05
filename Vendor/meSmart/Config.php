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
 */
class Config {

	/**
	 * 配置的信息就是保存在这个静态属性里的
	 *
	 * @var array
	 */
	private static $storage = array();

	/**
	 * 如果想要添加或修改一个配置的值，就使用这个方法
	 * 当传递的是一个数组时，这个方法内部会调用setAll
	 *
	 * @param string $name
	 * @param mix $value
	 * @return mix
	 */
	public static function set($name, $value)
	{
		// 数组内部调用setAll
		if(is_array($name)) {
			return static::setAll($name);
		}

		// 单个添加或修改
		if(!is_null($value)) {
			return static::$storage[$name] = $value;
		}
	}

	/**
	 * 得到一个配置的值
	 *
	 * @param string $name
	 * @return mix
	 */
	public static function get($name)
	{
		// 内部调用getAll
		if(is_null($name)) {
			return static::getAll();
		}

	    return isset(static::$storage[$name]) ? static::$storage[$name] : null;
	}

	/**
	 * 根据数组批量设置
	 * 根据数组 $key => $value的方式
	 *
	 * @param array $array
	 * @return array
	 */
	public static function setAll($array)
	{
		return Config::$storage = array_merge(Config::$storage, $array);
	}

	/**
	 * 获得所有的配置列表
	 *
	 * @return array
	 */
	public static function getAll()
	{
		return static::$storage;
	}
}