<?php
namespace meSmart;

class Core {

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
}