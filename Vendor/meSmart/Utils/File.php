<?php
namespace meSmart\Utils;

class File {

	private static $storage = array();

	public static $path = DATA_PATH;

	public static function get($name) {

		$filename = static::parse_name($name);

		// 如果设置了内存缓存则返回
		if (isset(static::$storage[$name])) {
			return static::$storage[$name];
		}

		// 获取缓存数据
		if (is_file($filename)) {
		    $value = include $filename;
		    static::$storage[$name] = $value;
		}
		// 不存在该文件
		else {
		    $value = false;
		}

		return $value;
	}

	public static function set($name, $value) {

		$filename = static::parse_name($name);

	    // 缓存数据
	    $dir = dirname($filename);

	    // 目录不存在则创建
	    if (!is_dir($dir)) {
	    	mkdir($dir,0755,true);
	    }

	    // 放入内存缓存
	    $_cache[$name]  =   $value;
	    return file_put_contents($filename, static::strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
	}

	public static function clear($name) {

		$filename = static::parse_name($name);

		return false !== strpos($name,'*') ? array_map("unlink", glob($filename)) : unlink($filename);
	}

	private static function parse_name($name) {
		return static::$path . $name . '.php';
	}

	/**
	 * 字符串命名风格转换
	 * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
	 *
	 * @param string $name 字符串
	 * @param integer $type 转换类型
	 *
	 * @return string
	 */
	public static function trans_name($name, $type=0) {
	    if ($type) {
	        return ucfirst(preg_replace("/_([a-zA-Z])/e", "strtoupper('\\1')", $name));
	    } else {
	        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
	    }
	}

	/**
	 * 去除代码中的空白和注释
	 *
	 * @param string $content 代码内容
	 *
	 * @return string
	 */
	function strip_whitespace($content) {
	    $stripStr   = '';
	    //分析php源码
	    $tokens     = token_get_all($content);
	    $last_space = false;
	    for ($i = 0, $j = count($tokens); $i < $j; $i++) {
	        if (is_string($tokens[$i])) {
	            $last_space = false;
	            $stripStr  .= $tokens[$i];
	        } else {
	            switch ($tokens[$i][0]) {
	                //过滤各种PHP注释
	                case T_COMMENT:
	                case T_DOC_COMMENT:
	                    break;
	                //过滤空格
	                case T_WHITESPACE:
	                    if (!$last_space) {
	                        $stripStr  .= ' ';
	                        $last_space = true;
	                    }
	                    break;
	                case T_START_HEREDOC:
	                    $stripStr .= "<<<THINK\n";
	                    break;
	                case T_END_HEREDOC:
	                    $stripStr .= "THINK;\n";
	                    for($k = $i+1; $k < $j; $k++) {
	                        if(is_string($tokens[$k]) && $tokens[$k] == ';') {
	                            $i = $k;
	                            break;
	                        } else if($tokens[$k][0] == T_CLOSE_TAG) {
	                            break;
	                        }
	                    }
	                    break;
	                default:
	                    $last_space = false;
	                    $stripStr  .= $tokens[$i][1];
	            }
	        }
	    }
	    return $stripStr;
	}
}