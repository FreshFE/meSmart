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
class Path implements Route {

	/**
	 * 这是一个数组，存放由parsePathinfo方法分析出来的path路径
	 * 默认为空数组
	 *
	 * @var array
	 */
	protected $paths;

	/**
	 * 存在控制器地址的数组
	 * 顺序分别为group name, controller name和method name
	 *
	 * @var array
	 */
	protected $controller;

	/**
	 * 分组列表，以,分割
	 * @var string
	 */
	protected $grouplist = 'Admin,Home,Api';

	/**
	 * 获得paths数组
	 * 当paths数组为空未定义时，则调$this->parse方法解析
	 *
	 * @return array
	 */
	public function getPaths()
	{
		if(is_null($this->paths)) {
			$this->parse();
		}

		return $this->paths;
	}

	/**
	 * 获得Controller Module
	 *
	 * @return string
	 */
	public function getModule()
	{
		if(is_null($this->controller)) {
			$this->parse();
		}

		return $this->controller['module'];
	}

	/**
	 * 获得Controller Method
	 *
	 * @return string
	 */
	public function getMethod()
	{
		if(is_null($this->controller)) {
			$this->parse();
		}

		return $this->controller['method'];
	}

	/**
	 * 类似于构造函数
	 * 测试时使用
	 */
	protected function parse()
	{
		$this->parsePathinfo();

		$this->parseController();

		$this->parseQuery();
	}

	/** 
	 * 分析$_SERVER['PATH_INFO']内的信息
	 * 将字符串pathinfo转化为数组paths
	 * 并存入类属性
	 *
	 * @return void
	 */
	protected function parsePathinfo()
	{
		$this->paths = array();

		if(isset($_SERVER['PATH_INFO']))
		{
			// 获得pathinfo并去除html标签和前后的'/'
			$pathinfo = strip_tags($_SERVER['PATH_INFO']);
			$paths = explode('/', trim($pathinfo, '/'));

			// 剔除group name
			if($paths[0] === strtolower(GROUP_NAME)) {
				array_shift($paths);
			}

			// 保存类属性
			$this->paths = $paths;
		}
	}

	/**
	 * 根据$this->paths分析相对应的controller和method
	 * 依次顺序为group name, controller name, method name
	 * 必须在parsePathinfo方法后执行该方法
	 *
	 * @return void
	 */
	protected function parseController()
	{
		$paths = $this->paths;

		$this->controller = array(
			'module' => isset($paths[0]) ? ucfirst($paths[0]) : 'Index',
			'method' => isset($paths[1]) ? $paths[1] : 'index'
		);
	}

	/**
	 * 根据$this->paths分析相对应的query部分
	 * 将解析出来的query部分合并到$_GET
	 * 先判断$paths数组的长度，如果不大于2则表明controller未写全或query部分不存在
	 * 当$paths数组的长度大于2时，按照'name/value'的格式转化为name => value的数组
	 * 最后将得到的结果与$_GET合并
	 *
	 * @return void
	 */
	protected function parseQuery()
	{
		if(count($this->paths) > 2)
		{
			$paths = $this->paths;
			$paths = array_splice($paths, 2);

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