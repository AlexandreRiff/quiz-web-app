<?php

define('DIR', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

include_once DIR . DS . 'config' . DS . 'config.php';

include_once DIR . DS . 'utils' . DS . 'autoload.php';

use http\Router;

$app = new Router();
$app->run();
