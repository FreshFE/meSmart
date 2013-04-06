<?php
namespace meSmart;

use \Exception;
use \ReflectionMethod;
use meSmart\Utils\Session as Session;

class Mapping {

	/**
	 * 解析路由的类
	 * 可以在分组Mapping内替换
	 *
	 * @var string
	 */
	public static $route = 'meSmart\\Routes\\Path';

	public static $view = 'meSmart\\Views\\Smarty';

	/**
	 * 在insert方法前执行的新的类的列表
	 *
	 * @var array
	 */
	public static $event_before = array();

	/**
	 * 在insert方法后执行的新的类的列表
	 *
	 * @var array
	 */
	public static $event_after = array();

	/**
	 * 拒绝执行的insert方法
	 *
	 * @var array
	 */
	public static $event_skip = array();

	/**
	 * 执行Mapping的相关操作
	 * 这是项目最关键的几个执行步骤
	 * 可以在分组的Mapping文件内的设置$event_before, $event_after, $event_skip几个数组
	 * 来插入新的执行类或者跳过当前类
	 */
	public static function exec()
	{
		// 路由解析
		static::event('route');

		// Session初始化
		static::event('session');

		// 用户认证
		static::event('auth');

		// 执行控制器
		static::event('controller');
	}

	/**
	 * 记录当前顺序执行什么static方法
	 * 该方法最关键的地方在可以执行$method的前置和后置方法，可以跳过当前方法的执行
	 *
	 * @param string $method
	 */
	protected static function event($method)
	{
		// 前置执行
		static::event_insert($method, static::$event_before);

		// 先判断是否拒绝执行，后再执行该方法
		if(!in_array($method, static::$event_skip))
		{
			static::$method();
		}

		// 后置执行
		static::event_insert($method, static::$event_after);
	}

	/**
	 * 把方法前置执行和后置执行的处理过程抽出来设的一个方法
	 * 专门是供event方法内部使用的
	 *
	 * @param string $method
	 * @param array $methods
	 */
	protected static function event_insert($method, $methods)
	{
		if(in_array($method, array_keys($methods)))
		{
			foreach (explode(',', $methods[$method]) as $key => $value) {
				if(!is_null($value)) {
					static::$value();
				}
			}
		}
	}

	/**
	 * 根据Mapping的关系，解析路由
	 * 根据程序执行的需求，路由必须实现getController接口
	 * 返回
	 * <code>
	 * 		array(
	 * 			'module' => '',
	 * 			'method' => ''
	 * 		);
	 * </code>
	 * 本方法根据返回的module和method，将这些相关的信息定义为常量
	 * 供exec程序执行，所以这些方法非常重要
	 */
	protected static function route()
	{
		$route = static::$route;

		$router = new $route();

		// !2. 模块名称，也就是相对应的Controller类
		define('MODULE_NAME', $router->getModule());

		// !3. 方法名称，Controller类下执行什么方法
		define('METHOD_NAME', $router->getMethod());
	}

	/**
	 * 启动session
	 */
	protected static function session()
	{
		Session::start();
	}

	/**
	 * 用户认证
	 */
	protected static function auth()
	{

	}

	/**
	 * 执行程序
	 * 根据上面的配置得到了GROUP_NAME, MODULE_NAME & METHOD_NAME
	 * 根据这些信息，准确的找到执行何分组下何类的何方法
	 */
	protected static function controller()
	{
		try
		{	
			// -------------------------------------------
			// 解析Module部分
			// -------------------------------------------

			// 安全过滤
			if(!preg_match('/^[A-Za-z](\w)*$/', MODULE_NAME))
			{
			    throw new Exception('This controller name is danger!');
			}
			// 加载module类
			else {
			    $module = 'App\\'.GROUP_NAME.'\\Controllers\\'.MODULE_NAME;

			    // 检查是否存在
			    if(class_exists($module)) {
			    	$controller = new $module;
			    }
			    else {
			    	throw new Exception(MODULE_NAME.' is no extis!');
			    }
			}

			// -------------------------------------------
			// 解析Method部分
			// -------------------------------------------

			// 安全过滤
			if(!preg_match('/^[A-Za-z](\w)*$/', METHOD_NAME))
			{
			    throw new Exception('This controller method is error!');
			}
			else {
				// 方法名
				$method = METHOD_NAME;

				// 对当前控制器的方法执行操作映射
				$reflection = new ReflectionMethod($controller, $method);
				
				// public方法
				if($reflection->isPublic()) {
					$controller->$method();
				}
				// 操作方法不是Public 抛出异常
				else {
				    throw new Exception(METHOD_NAME.'not public method!');
				}
			}

		} catch (Exception $e) {
			Base::error($e);
		}
	}
}