<?php

// -------------------------------------------
// regitsrt autoload
// -------------------------------------------
spl_autoload_register(function($classname) {

	// echo $classname;
	// exit();

	$filename = realpath(VENDOR_PATH . str_replace('\\', '/', $classname) . '.php');

	if($filename) {
		include $filename;
	}
	else {
		exit("autoload don't find the class and file, ".$classname);
	}
});