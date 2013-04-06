<?php
namespace meSmart\Controllers;
/**
 * meSmart php
 * Copyright (c) 2004-2013 Methink
 * @copyright     Copyright (c) Methink
 * @link          https://github.com/minowu/meSmart
 * @package       meSmart.Controllers.Base
 * @since         meSmart php 0.1.0
 * @license       Apache License (http://www.apache.org/licenses/LICENSE-2.0)
 */

use meSmart;

/**
 * 基础控制器类
 * 我是被继承使用的，所以在GROUP_NAME\Controllers中继承我吧
 * 亲，我是你们的父亲，你们得承认
 * 额，其实吧，也可以换其他的父亲进行继承
 * 当然啦，很有可能，我一不小心就变成你们的爷爷、曾爷爷，甚至是神话中的祖先了，嘿嘿！！
 */
class Base {

	/**
	 * 存放视图类的属性
	 * 由get_view方法初始化
	 * 当该类不为空的时候，get_view方法直接返回该属性
	 *
	 * @var object
	 */
	protected $view;

	/**
	 * 用于存放输出变量的数组
	 * 由assign方法来添加
	 * 在输出时，可以由display, fetch, output使用
	 *
	 * @var array
	 */
	protected $vars;

	/**
	 * 用于输出的模板文件的后缀
	 *
	 * @var string
	 */
	protected $template_suffix = '.html';

	/**
	 * 构造函数
	 * 现在好像什么都没做~ ~ ~
	 */
	public function __construct()
	{

	}

	/**
	 * 获得视图类
	 * 当调用视图类时但该类并未初始化时会通过Mapping里配置的View信息来初始化
	 *
	 * @return object $this->view
	 */
	protected function get_view()
	{

		if(is_null($this->view)) {

			// 获得Mapping名称
			$mapping = meSmart\Main::$mapping;

			// 获得view名称
			$view = $mapping::$view;

			// 实例化并返回
			return $this->view = new $view();
		}
		else {
			return $this->view;
		}
	}

	/**
	 * 调用get_view里初始化的view类的方法
	 * 一般在view中定义了fetch方法，用于渲染模板并返回字符串格式内容
	 * 参数$template同$this->diaplay方法
	 *
	 * @param string $template
	 * @return string
	 */
	protected function fetch($template)
	{
		return $this->get_view()->fetch($this->template_file($template), $this->vars);
	}

	/**
	 * 调用get_view得到view实例
	 * 并在内部再次使用$this->view->fetch的方法，但是多一个参数，是$display = true表示输出
	 * 为什么这样做，是因为这样可以使用Smarty默认做的输出和缓存
	 * $template参数表示的是模板路径，默认为空时由控制器自动计算，通常为该控制器自己的名称加方法名称
	 *
	 * @param string $template
	 * @return void
	 */
	protected function display($template)
	{
		$this->get_view()->display($this->template_file($template), $this->vars);
	}

	/**
	 * 解析控制器输出的模板文件的名称
	 *
	 * @param string $template
	 * @return string
	 */
	protected function template_file($template)
	{
		if(is_null($template) or $template === '')
		{
			$name = MODULE_NAME.'/'.METHOD_NAME;
		}
		else if(count(explode('/', $template)) == 1)
		{
			$name = MODULE_NAME.'/'.$template;
		}
		else {
			$name = $template;
		}
		return $name.$this->template_suffix;
	}

	/**
	 * 给$this->vars赋值
	 *
	 * @param string|array $name
	 * @param mixed $value
	 */
	protected function assign($name, $value)
	{
		if(is_array($name)) {
			array_merge($this->vars, $name);
		}
		else {
			$this->vars[$name] = $value;
		}
	}

	/**
	 * 结束程序并输出
	 * 默认使用ajax方式输出
	 */
	protected function output($type = 'ajax')
	{
		if($type == 'ajax')
		{
			exit(json_encode($this->vars));
		}
	}
}