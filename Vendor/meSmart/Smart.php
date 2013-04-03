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

use App;

/*
 * 创建项目架构，分析路由
 * 载入 App & group Config
 * 执行controller->method()
 */
class Smart {

	/**
	 * http request pathinfo
	 * 在static::parseRoute()后被赋值
	 *
	 * @var array
	 */
	public static $paths;

	/**
	 * controller使用的分组名
	 * 在static::parseRoute()后被赋值
	 *
	 * @var string
	 */
	public static $group;

	/**
	 * controller使用的模块名
	 * 在static::parseRoute()后被赋值
	 *
	 * @var string
	 */
	public static $module;

	/**
	 * controller使用的方法名
	 * 在static::parseRoute()后被赋值
	 *
	 * @var string
	 */
	public static $method;

	/**
	 * 配置信息
	 *
	 * @var string
	 */
	public static $config;

	/**
	 * 建设整个Application就是由这里开始的
	 * ~_~， Good luck to you!
	 *
	 * @return void
	 */
	public static function build()
	{
		// 分析路由
		static::parseRoute();

		// 加载配置，App & group config
		static::parseConfig();

		// 加载行为
		// static::parseTag();

		// 加载语言
		// static::parseLang();

		// 初始化关键参数
		static::parseReq();

		static::parseRes();

		// 加载Session
		// Session::config();

		// 执行程序
		// static::exec();
	}

	/**
	 * 解析路由，根据路由内的'getPaths' & 'getController'方法
	 * 并将获得存入类静态属性内
	 *
	 * @return void
	 */
	private static function parseRoute()
	{
		// 实例化App\Route，该Route由App项目定义，一般由App项目继承meSmart内预置类
		$route = new App\Route;

		// 将paths和controller存入类静态属性
		static::$paths = $route->getPaths();

		// 获得controller
		$controller = $route->getController();

		// 存入静态类
		static::$group = $controller['group'];
		static::$module = $controller['module'];
		static::$method = $controller['method'];
	}

	/**
	 * 加载分组配置
	 */
	private static function parseConfig()
	{
		$class = 'App\\'.static::$group.'\\Config';
		static::$config = new $class;
	}

	/**
	 * 解析发送
	 */
	private static function parseRes()
	{
		// 设置系统时区
        date_default_timezone_set(Config::get('default_timezone'));
	}

	/**
	 * 解析请求
	 */
	private static function parseReq()
	{
		// 系统变量安全过滤
		if(Config::get('var_filters'))
		{
		    foreach(explode(',', Config::get('var_filters')) as $filter)
		    {
		        array_walk_recursive($_POST, $filter);
		        array_walk_recursive($_GET, $filter);
		    }
		}
	}
}