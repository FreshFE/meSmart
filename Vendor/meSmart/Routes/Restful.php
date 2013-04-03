<?php
namespace meSmart\Routes;

use meSmart;

class Restful {

	/**
	 * 这是一个数组，存放由parsePathinfo方法分析出来的path路径
	 * 默认为空数组
	 *
	 * @var array
	 */
	protected $paths = array();

	/**
	 * 存在控制器地址的数组
	 * 顺序分别为group name, controller name和method name
	 *
	 * @var array
	 */
	protected $controller = array();

	/**
	 * 分组列表，以,分割
	 * @var string
	 */
	protected $grouplist = 'Home,Admin,Api';

	/**
	 * 类似于构造函数
	 * 测试时使用
	 */
	public function parse()
	{
		$this->parsePathinfo();

		$this->parseController();

		$this->parseQuery();
		dump($this->paths);

		// dump([$this->paths, $this->controller]);
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
		if(isset($_SERVER['PATH_INFO']))
		{
			$pathinfo = strip_tags($_SERVER['PATH_INFO']);
			$this->paths = explode('/', trim($pathinfo, '/'));
		}
	}

	/**
	 * 根据$this->paths分析相对应的controller和method
	 * 依次顺序为group name, controller name, method name
	 * 必须在parsePathinfo方法后执行该方法
	 */
	protected function parseController()
	{
		$paths = $this->paths;

		// 首字母大写
		$name = ucfirst($paths[0]);
		$list = explode(',', $this->grouplist);
		
		// 如果不存在
		if(!in_array($name, $list)) {
			$name = 'Home';
			$key = 0;
		}
		// 如果存在
		else {
			$key = 1;
		}

		$this->controller = array(
			'name' => $name,
			'module' => isset($paths[$key]) ? $paths[$key] : 'Index',
			'action' => isset($paths[$key + 1]) ? $paths[$key + 1] : 'index'
		);
	}

	protected function parseQuery()
	{
		if(count($this->paths) > 3)
		{
			$paths = $this->paths;
			$paths = array_splice($paths, 3);

			
		}
	}

}