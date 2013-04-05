<?php
namespace meSmart;

class Session {

	/**
	 * 初始化配置session
	 * session 函数参考，http://www.php.net/manual/zh/ref.session.php
	 * session runtime 配置参考，http://www.php.net/manual/zh/session.configuration.php
	 *
	 * @param $name
	 * @return void
	 */
	public static function init($name) {

		// 配置session id
		if(isset($name['id']))
		{
			session_id($name['id']);
		}

		// 关闭session自动开始
		ini_set('session.auto_start', 0);

		// 1. session name, e.g. PHPSESSID，所以一般情况下不要更改
		if(isset($name['name']))            session_name($name['name']);

		// 2. session path, Session保存的路径
		if(isset($name['path']))            session_save_path($name['path']);

		// 3. session domain, 域名
		if(isset($name['domain']))          ini_set('session.cookie_domain', $name['domain']);

		// 4. session expire, 存在时间
		if(isset($name['expire']))          ini_set('session.gc_maxlifetime', $name['expire']);

		// 5. 是否解析用户发送在url内的session id，默认为关闭
		if(isset($name['use_trans_sid']))   ini_set('session.use_trans_sid', $name['use_trans_sid'] ? 1 : 0);

		// 6. 是否使用cookie来配合session保存session值
		if(isset($name['use_cookies']))     ini_set('session.use_cookies', $name['use_cookies'] ? 1 : 0);

		// 7. 缓存限制
		if(isset($name['cache_limiter']))   session_cache_limiter($name['cache_limiter']);

		// 8. 缓存时间
		if(isset($name['cache_expire']))    session_cache_expire($name['cache_expire']);

		// 启动session
		session_start();
	}

	/**
	 * 获得一个session的值
	 *
	 * @param string $name
	 * @return mixed
	 */
	public static function get($name) {
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}

	/**
	 * 设置一个session的值
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return mixed
	 */
	public static function set($name, $value)
	{
		if(!is_null($value)) {
			return $_SESSION[$name] = $value;
		}

		return false;
	}

	/**
	 * 删除指定的session
	 *
	 * @param string $name
	 * @return bealoon
	 */
	public static function delete($name)
	{
		if(isset($_SESSION[$name])) {
			unset($_SESSION[$name]);
			return true;
		}

		return false;
	}

	/**
	 * 检查该Session是否存在
	 *
	 * @param string $name
	 * @return bealoon
	 */
	public static function check($name) {

		return isset($_SESSION[$name]) ? true : false;
	}

	/**
	 * 清除所有的session值
	 *
	 * @return void
	 */
	public static function clear() {
		$_SESSION = array();
	}

	/**
	 * 启动session
	 *
	 * @return void
	 */
	public static function start() {
		session_start();
	}

	/**
	 * 暂停session写入
	 *
	 * @return void
	 */
	public static function pause() {
		session_write_close();
	}

	/**
	 * 摧毁session
	 *
	 * @return void
	 */
	public static function destroy() {
		$_SESSION =  array();
		session_unset();
		session_destroy();
	}

	/**
	 * 重新生成session id
	 *
	 * @return void
	 */
	public static function regenerate() {
		session_regenerate_id();
	}
}