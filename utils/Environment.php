<?php

namespace utils;

class Environment
{
	public static function load($dir)
	{
		if (file_exists($dir . '/.env')) {
			$lines = file($dir . '/.env');
			foreach ($lines as $line) {
				putenv(trim($line));
			}
		} else {
			return false;
		}
	}
}