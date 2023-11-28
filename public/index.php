<?php

use App\Core\Router;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$dispatcher = require __DIR__ . '/../app/routes.php';

Router::run($dispatcher);
