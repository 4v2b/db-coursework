<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Initialize the framework
$router = new \App\Core\Router();

$router->setBasePath('/database_coursework/public');
// Define routes
$router->get('/', 'HomeController@login');


$router->get('/login', 'HomeController@login');
$router->post('/auth', 'HomeController@authenticate');
$router->get('/logout', 'HomeController@logout');

// Run the application
$router->run();
//$router->show();

