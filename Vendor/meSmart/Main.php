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
define('LOG_PATH', RUNTIME_PATH . 'Logs/');

// 2. 模板
define('TEMP_PATH', RUNTIME_PATH . 'Temp/');

// 3. 文件
define('DATA_PATH', RUNTIME_PATH . 'Data/');

// 4. 缓存
define('CACHE_PATH', RUNTIME_PATH . 'Cache/');

// -------------------------------------------
// meSmart Main Class, Main::run() to begin
// -------------------------------------------
class Main {

	/**
	 * 将meSmart\Main运行起来
	 */
	public static function run()
	{
		static::check_version();

		static::define_const();

		static::build_app();
	}

	private static function check_version() {

		// php错误输出
		if (APP_DEBUG && !ini_get('display_errors')) {
		    ini_set('display_errors', 1);
		}
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
		// 检查缓存路径
		if(APP_DEBUG && !is_dir(RUNTIME_PATH)) {
			static::build_runtime();
		}

		// 启动程序
		Application::build();
	}

	/**
	 * 创建运行时的缓存目录
	 */
	private static function build_runtime()
	{
		// 如果不存在Runtime则创建
		if(!is_dir(RUNTIME_PATH)) {
		    mkdir(RUNTIME_PATH);
		}
		else {
			exit('Can\'t create runtime path');
		}

		// 检查并创建Runtime下的缓存目录
		foreach (array(CACHE_PATH, LOG_PATH, TEMP_PATH, DATA_PATH) as $key => $value)
		{
		    if(!is_dir($value)) mkdir($value);
		}
	}
}