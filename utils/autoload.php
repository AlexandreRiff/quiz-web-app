<?php

	spl_autoload_register(function ($class) {
		$filename = DIR . DS . str_replace('\\', DS, $class) . '.php';
		if (file_exists($filename)) {
			include_once $filename;
		}
	});
