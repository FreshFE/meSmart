<?php
namespace meSmart;

class Routes {

	protected $mode = 'common';

	protected $mapping = array();

	public function __construct()
	{
		// 解析路由请求
		$this->parse();

	}

	protected function parse() {
		
	}
}