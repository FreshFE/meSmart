<?php
namespace meSmart;
/**
 * meSmart php
 * Copyright (c) 2004-2013 Methink
 * @copyright     Copyright (c) Methink
 * @link          https://github.com/minowu/meSmart
 * @package       meSmart
 * @since         meSmart php 0.1.0
 * @license       Apache License (http://www.apache.org/licenses/LICENSE-2.0)
 */

/*
 * meSmart 核心方法
 * 这个静态类主要是一些核心常用方法的集合类
 */
class Core {

	/**
	 * 得到分组名称
	 * 通过分析pathinfo，得到当前的url分组
	 * 后期将加入功能，使得分组可以具有二级域名分析能力
	 *
	 * @return string
	 */
	public static function get_group_name()
	{
		// 获得pathinfo
		$path = trim($_SERVER['PATH_INFO'], '/');

		// 获得分组列表
		$groups = explode(',', 'Admin,Home,Api');

		// 默认分组名称
		$group_name = 'Home';

		// 遍历groups，寻找匹配的 Group Name
		foreach ($groups as $key => $group) {
			if(strpos(strtolower($path), strtolower($group)) === 0) {
				$group_name = $group;
				break;
			}
		}

		return $group_name;
	}

	/**
	 * 按序检查多个类是否存在
	 * 若存在则不再检查下一个类，若不存在则逐序向下检查
	 *
	 * @param array $classes
	 * @return void
	 */
	public static function classes_exists(array $classes)
	{
		foreach ($classes as $key => $class) {
			if(class_exists($class)) {
				return $class;
			}
		}
	}

	/**
	 * 如果程序通过try catch抛出错误
	 * 则可以通过使用error来调整输出错误的格式和错误信息
	 *
	 * @param \Exception $error
	 * @return void
	 */
	public static function error(\Exception $error)
	{
		if(APP_DEBUG) {
			echo $error->getMessage();
		}
	}
}