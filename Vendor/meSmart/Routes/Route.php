<?php
namespace meSmart\Routes;

/**
 * 路由接口
 * 供路由相关类实现，由项目Mapping执行
 * 规定的接口都是必须实现的
 */
interface Route {

	/**
	 * 获得处理后的url paths
	 * 获得paths必须是数组格式，并且在剔除group信息后
	 *
	 * @return array
	 */
	public function getPaths();

	/**
	 * 在处理group name后得到的module name
	 * 返回的必须是字符串
	 *
	 * @return string
	 */
	public function getModule();

	/**
	 * 在处理group name后得到的Controller method name
	 * 返回的必须是字符串
	 *
	 * @return string
	 */
	public function getMethod();
}