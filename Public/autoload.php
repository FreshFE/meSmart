<?php

// -------------------------------------------
// echo autoload error
// -------------------------------------------
if(!defined('AUTOLOAD_DEBUG'))
{
	define('AUTOLOAD_DEBUG', false);
}

// -------------------------------------------
// regitsrt autoload
// -------------------------------------------
spl_autoload_register(function($classname) {

	if(strpos($classname, 'App') === 0) {
		$filename = APP_PATH . ltrim(str_replace('\\', '/', $classname), 'App') . '.php';
	}
	else {
		$filename = VENDOR_PATH . str_replace('\\', '/', $classname) . '.php';
	}

	$file = realpath($filename);

	if($file) {
		include $file;
	}
	else if(AUTOLOAD_DEBUG) {
		exit("autoload don't find the class and file, '" . $classname . "', filename is " . $filename);
	}
});