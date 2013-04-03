<?php
namespace meSmart;

// -------------------------------------------
// meSmart 路径
// -------------------------------------------
define('MESMART_PATH', dirname(__FILE__) . '/');

// -------------------------------------------
// Runtime 路径
// -------------------------------------------
// 1. 日志
define('RUNTIME_LOG_PATH', RUNTIME_PATH . 'Logs/');

// 2. 模板
define('RUNTIME_TEMP_PATH', RUNTIME_PATH . 'Temp/');

// 3. 文件
define('RUNTIME_DATA_PATH', RUNTIME_PATH . 'Data/');

// 4. 缓存
define('RUNTIME_CACHE_PATH', RUNTIME_PATH . 'Cache/');

// -------------------------------------------
// meSmart Main Class, Main::run() to begin
// -------------------------------------------
class Main {

	/**
	 * 将meSmart\Main运行起来
	 */
	public static function run()
	{
		static::define_const();

		static::build_app();
	}

	/**
	 * 定义meSmart的常量
	 * 这些常量非常的重要，在框架里随时都会被用到
	 */
	private static function define_const()
	{

	}

	/**
	 * 创建起app
	 */
	private static function build_app()
	{
		if(APP_DEBUG && !is_dir(RUNTIME_PATH)) {
			static::build_runtime();
		}
	}

	private static function build_runtime()
	{
		// 如果不存在Runtime则创建
		if(!is_dir(RUNTIME_PATH)) {
		    mkdir(RUNTIME_PATH);
		}
		// 如果Runtime不可写返回
		else if(!is_writeable(RUNTIME_PATH)) {
		    exit(RUNTIME_PATH . 'is no writeable');
		}

		// 检查并创建Runtime下的缓存目录
		foreach (array(
			RUNTIME_CACHE_PATH, RUNTIME_LOG_PATH,
			RUNTIME_TEMP_PATH, RUNTIME_DATA_PATH) as $key => $value)
		{
		    if(!is_dir($value)) mkdir($value);
		}
	}
}