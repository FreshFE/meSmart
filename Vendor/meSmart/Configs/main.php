<?php

return array(

	'app_status' => 'debug',

	'session_config' => array(),

	// -------------------------------------------
	// 数据库配置
	// -------------------------------------------
	/**
	 * 1. 数据库类型，可以使用其他数据库类型，并配合驱动扩展使用
	 * 2. 服务器地址
	 */
	'DB_TYPE'               => 'mysql',
	'DB_HOST'               => 'localhost',

	/**
	 * 1. 数据库名
	 * 2. 用户名
	 * 3. 密码
	 */
	'DB_NAME'               => '',
	'DB_USER'               => 'root',
	'DB_PWD'                => '',

	/**
	 * 1. 端口
	 * 2. 数据库表前缀
	 * 3. 数据库编码默认采用utf8
	 */
	'DB_PORT'               => '',
	'DB_PREFIX'             => '',
	'DB_CHARSET'            => 'utf8',

	/**
	 * 是否进行字段类型检查
	 * TODO: 当前没有地方用到
	 */
	'DB_FIELDTYPE_CHECK'    => false,

	/**
	 * 启用字段缓存
	 */
	'DB_FIELDS_CACHE'       => true,

	/**
	 * 1. 数据库部署方式:0 集中式(单一服务器), 1 分布式(主从服务器)
	 * 2. 数据库读写是否分离 主从式有效
	 * 3. 读写分离后 主服务器数量
	 * 4. 指定从服务器序号
	 */
	'DB_DEPLOY_TYPE'        => 0,
	'DB_RW_SEPARATE'        => false,
	'DB_MASTER_NUM'         => 1,
	'DB_SLAVE_NO'           => '',

	/**
	 * 1. 数据库查询的SQL创建缓存
	 * 2. SQL缓存队列的缓存方式 支持 file xcache和apc
	 * 3. SQL缓存的队列长度
	 */
	'DB_SQL_BUILD_CACHE'    => false,
	'DB_SQL_BUILD_QUEUE'    => 'file',
	'DB_SQL_BUILD_LENGTH'   => 20,

	/**
	 * SQL执行日志记录
	 */
	'DB_SQL_LOG'            => false
);