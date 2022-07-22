<?php

include_once __DIR__ . DS . '..' . DS . 'utils' . DS . 'Environment.php';

use utils\Environment;

Environment::load('./');

date_default_timezone_set('America/Sao_Paulo');

define('DB_SGBD', getenv('DB_SGBD'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
