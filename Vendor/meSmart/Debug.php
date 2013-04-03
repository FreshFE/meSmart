<?php
namespace meSmart;

class Debug {

	/**
	 * 浏览器友好的变量输出
	 *
	 * @param mixed $var 变量
	 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
	 * @param string $label 标签 默认为空
	 * @param boolean $strict 是否严谨 默认为true
	 *
	 * @return void|string
	 */
	public static function dump($var, $label = null, $echo = true, $strict = true)
	{
	    $label = ($label === null) ? '' : rtrim($label) . ' ';

	    // 普通模式
	    if(!$strict)
	    {
	        if(ini_get('html_errors')) {
	            $output = print_r($var, true);
	            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
	        }
	        else {
	            $output = $label . print_r($var, true);
	        }
	    }
	    // 严格模式
	    else {
	        ob_start();
	        var_dump($var);
	        $output = ob_get_clean();
	        if (!extension_loaded('xdebug')) {
	            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
	            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
	        }
	    }
	    // 打印或返回
	    if ($echo) {
	        echo($output);
	        return null;
	    }
	    else {
	    	return $output;
	    }
	}
}