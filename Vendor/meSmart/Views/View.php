<?php
namespace meSmart\Views;
/**
 * meSmart php
 * Copyright (c) 2004-2013 Methink
 * @copyright     Copyright (c) Methink
 * @link          https://github.com/minowu/meSmart
 * @package       meSmart.Views.View interface
 * @since         meSmart php 0.1.0
 * @license       Apache License (http://www.apache.org/licenses/LICENSE-2.0)
 */

/**
 * 视图接口
 * 供视图相关类实现，由项目Mapping执行
 * 可以在Mapping中改变视图类的名称和路径
 */
interface View {

	/**
	 * 渲染模板直接返回字符串
	 *
	 * @param string $name 模板路径
	 * @param array $vars 需赋值的数组
	 * @return string
	 */
	public function fetch($name, $vars);

	/**
	 * 渲染模板并输出
	 * 配合使用缓存等设置
	 * @param string $name 模板路径
	 * @param array $vars 需赋值的数组
	 * @return void
	 */
	public function display($name, $vars);
}