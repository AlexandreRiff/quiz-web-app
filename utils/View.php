<?php

namespace utils;

class View
{

	public static function render($view)
	{
		$file = DIR . DS . "public" . DS . "dist" . DS . "{$view}.html";
		if (file_exists($file)) {
			echo (file_get_contents($file));
		}
	}
}
