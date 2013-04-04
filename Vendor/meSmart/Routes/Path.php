<?php
namespace meSmart\Routes;
/**
 * meSmart php
 * Copyright (c) 2004-2013 Methink
 * @copyright     Copyright (c) Methink
 * @link          https://github.com/minowu/meSmart
 * @package       meSmart.Routes
 * @since         meSmart php 0.1.0
 * @license       Apache License (http://www.apache.org/licenses/LICENSE-2.0)
 */

use meSmart;

/*
 * 解析url路径，匹配到controller供meSmart和App使用
 * 实现接口 'getPaths' 和 'getController'
 */
class Path {

	/**
	 * 这是一个数组，存放由parsePathinfo方法分析出来的path路径
	 * 默认为空数组
	 *
	 * @var array
	 */
	protected static $paths;

	/**
	 * 存在控制器地址的数组
	 * 顺序分别为group name, controller name和method name
	 *
	 * @var array
	 */
	protected static $controller;

	/**
	 * 分组列表，以,分割
	 * @var string
	 */
	protected static $grouplist = 'Admin,Home,Api';

	/**
	 * 获得paths数组
	 * 当paths数组为空未定义时，则调$this->parse方法解析
	 *
	 * @return array
	 */
	public static function getPaths()
	{
		if(is_null(static::$paths)) {
			static::parse();
		}

		return static::$paths;
	}

	/**
	 * 获得controller数组
	 * controller数组分为三项，分别为'group', 'module' & 'method'
	 * 必须定义该接口供meSmart判断当前加载分组下的controller->method()
	 *
	 * @return array
	 */
	public static function getController()
	{
		if(is_null(static::$controller)) {
			static::parse();
		}

		return static::$controller;
	}

	/**
	 * 类似于构造函数
	 * 测试时使用
	 */
	protected static function parse()
	{
		static::parsePathinfo();

		static::parseController();

		static::parseQuery();
	}

	/** 
	 * 分析$_SERVER['PATH_INFO']内的信息
	 * 将字符串pathinfo转化为数组paths
	 * 并存入类属性
	 *
	 * @return void
	 */
	protected static function parsePathinfo()
	{
		static::$paths = array();

		if(isset($_SERVER['PATH_INFO']))
		{
			$pathinfo = strip_tags($_SERVER['PATH_INFO']);
			static::$paths = explode('/', trim($pathinfo, '/'));
		}
	}

	/**
	 * 根据$this->paths分析相对应的controller和method
	 * 依次顺序为group name, controller name, method name
	 * 必须在parsePathinfo方法后执行该方法
	 */
	protected static function parseController()
	{
		$paths = static::$paths;

		if($paths[0] === strtolower(GROUP_NAME)) {
			array_shift($paths);
		}

		static::$controller = array(
			'module' => isset($paths[0]) ? ucfirst($paths[0]) : 'Index',
			'method' => isset($paths[1]) ? $paths[1] : 'index'
		);
	}

	/**
	 * 根据$this->paths分析相对应的query部分
	 * 将解析出来的query部分合并到$_GET
	 * 先判断$paths数组的长度，如果不大于3则表明controller未写全或query部分不存在
	 * 当$paths数组的长度大于3时，按照'name/value'的格式转化为name => value的数组
	 * 最后将得到的结果与$_GET合并
	 *
	 * @return void
	 */
	protected static function parseQuery()
	{
		if(count(static::$paths) > 3)
		{
			$paths = static::$paths;
			$paths = array_splice($paths, 3);

			// 偶数项为name，奇数项为value
			foreach ($paths as $key => $path) {
				if($key % 2) {
					$temp[$paths[$key - 1]] = $path;
				}
			}

			// 合并到$_GET
			return $_GET = array_merge($_GET, $temp);
		}
	}

}