<?php
namespace meSmart\Views;

use \Smarty as SmartyEngine;

class Smarty implements View {

	public $engine;

	public function __construct()
	{
		// 载入
		$this->import();

		// 实例化
		$this->engine = new SmartyEngine();

		// 配置
		$this->config();

		return $this;
	}

	protected function import()
	{
		include_once MESMART_PATH.'Views/Smarty/Smarty.class.php';
	}

	protected function config()
	{
		// 是否开启缓存, 模板目录, 编译目录, 缓存目录
		$this->engine->caching           = true;
		$this->engine->template_dir      = APP_PATH . GROUP_NAME.'/'.'Templates/';
		$this->engine->compile_dir       = CACHE_PATH;
		$this->engine->cache_dir         = TEMP_PATH;
		$this->engine->debugging         = false;
		$this->engine->left_delimiter    = '{{';
		$this->engine->right_delimiter   = '}}';
	}

	protected function assign($array)
	{
		$this->engine->assign($array);
	}

	public function fetch($name, $array, $display)
	{
		$this->assign($array);

		if($display) {
			$this->engine->display($name);
		}
		else {
			return $this->engine->fetch($name);
		}
	}
}