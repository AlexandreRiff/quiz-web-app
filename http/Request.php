<?php

namespace http;

class Request
{

	public static function post($param, $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS)
	{
		return filter_input(INPUT_POST, $param, $filter);
	}

	public static function get($param, $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS)
	{
		return filter_input(INPUT_GET, $param, $filter);
	}
}
