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
// meSmart Main Class, Main::init() to begin
// -------------------------------------------
class Main {

	/**
	 * 项目最核心的类映射就是存储在这里的
	 * 你要继续往下看代码就会看到这个是干什么的了
	 *
	 * @var array
	 */
	public static $mapping;

	/**
	 * 将meSmart\Main运行起来
	 * ~_~ meSmart 开始了哦
	 * Good luck to you! 嘿嘿，你懂得
	 */
	public static function init()
	{
		// 初始化当前PHP版本和PHP输出
		static::init_php();

		// 定义框架常量
		// TODO: 可能被废弃
		static::constant();

		// 检查缓存路径，
		// 如果不存在则创建
		static::runtime();

		// 解析url请求，
		// 分析当前请求匹配什么App分组，并定义常量GROUP_NAME
		static::group();

		// 加载分组的核心配置文件，并执行应用
		static::start_app();
	}

	/**
	 * 检查PHP版本
	 * 设置PHP错误输出级别
	 */
	private static function init_php() {

		// php错误输出
		if (APP_DEBUG && !ini_get('display_errors')) {
			error_reporting(E_ERROR);
		    ini_set('display_errors', 1);
		}
	}

	/**
	 * 定义meSmart的常量
	 * 这些常量非常的重要，在框架里随时都会被用到
	 */
	private static function constant()
	{

	}

	/**
	 * 创建运行时的缓存目录
	 * App调试模式下执行，检查Runtime目录是否存在，不存在则创建
	 */
	private static function runtime()
	{
		if(APP_DEBUG)
		{
			// 如果不存在Runtime则创建
			if(!is_dir(RUNTIME_PATH)) {
			    if(!mkdir(RUNTIME_PATH)) {
			    	exit('No access to create runtime directory.');
			    }
			}

			// 检查并创建Runtime下的缓存目录
			foreach (array(CACHE_PATH, LOG_PATH, TEMP_PATH, DATA_PATH) as $key => $value)
			{
			    if(!is_dir($value)) mkdir($value);
			}
		}
	}

	/**
	 * 解析URL Pathinfo信息，匹配到App项目相对应的分组
	 * 找到App分组后，后续程序的操作加载都由分组内的文件决定
	 */
	private static function group()
	{
		// 得到group name
		$group_name = Core::get_group_name();

		// !1. 定义 Group Name，非常重要，后续加载何分组文件都依赖于这个路径
		define('GROUP_NAME', $group_name);
	}

	/**
	 * 开始构建整个Application
	 * 在获得Group name & group path后
	 * 程序开始加载App下相应文件，并初始化
	 */
	private static function start_app()
	{
		// 解析加载映射
		static::start_mapping();

		// 解析配置
		static::start_config();

		// 执行程序
		static::exec_mapping();
	}

	/**
	 * 核心映射
	 * 告诉meSmart应该使用哪个route, tag, language类
	 * 默认先加载App group分组下的Mapping，不存在的话则读取meSmart下的Mapping
	 * 开发者可以通过修改App下Mapping的继承关系来改变类映射关系
	 * 执行该方法后，该方法的Mapping映射关系将会被保存到Main的mapping静态属性内，供其他类直接使用
	 */
	private static function start_mapping()
	{
		// static::$mapping = Core::classes_exists(array(
		// 	'App\\'.GROUP_NAME.'\\Mapping',
		// 	__NAMESPACE__.'\\Mapping'
		// ));

		static::$mapping = 'App\\'.GROUP_NAME.'\\Mapping';
	}

	/**
	 * 加载配置信息
	 * 依次加载meSmart配置，App配置和Group配置，并将新的覆盖旧的
	 */
	private static function start_config()
	{
		// 框架配置
		Config::set(include MESMART_PATH.'Configs/main.php');

		// 项目配置
		Config::set(include APP_PATH.'Configs/main.php');

		// 分组配置
		Config::set(include GROUP_PATH.'Configs/main.php');
	}

	/**
	 * 执行核心映射的功能
	 * 核心映射文件可以被分组的Mapping.php继承，重写和扩展
	 * 也就是说可以在Mapping里做任何你想新添加的事情
	 * 而随着meSmart越来越完善，能提供被继承的包也会越来越多
	 * 当然，还有就是我们很提倡使用很多已经很常用和成熟的第三方库！
	 */
	private static function exec_mapping()
	{
		$mapping = static::$mapping;
		$mapping::exec();
	}
}