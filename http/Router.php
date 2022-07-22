<?php

namespace http;

use http\Request;

class Router
{
	private $uri;
	private $controller;
	private $method;
	private $params;

	public function __construct()
	{
		$this->uri = Request::get('uri', FILTER_SANITIZE_URL);
		$this->controller = 'Home';
		$this->method = 'index';
	}

	public function run()
	{
		if (!empty($this->uri)) {
			$this->uri = explode('/', $this->uri);
			$this->controller = ucfirst($this->uri[0]);
			unset($this->uri[0]);
			if (isset($this->uri[1])) {
				$this->method = $this->uri[1];
				unset($this->uri[1]);
			}
		}

		if (file_exists(DIR . DS . 'controller' . DS . $this->controller . '.php')) {
			$this->controller = 'controller\\' . $this->controller;
			$this->controller = new $this->controller();
			if (method_exists($this->controller, $this->method)) {
				$this->params = is_array($this->uri) ? array_values($this->uri) : [];
				return call_user_func_array(array($this->controller, $this->method), $this->params);
			}
		}
		http_response_code(404);
		die('error: 404 Not Found');
	}
}
