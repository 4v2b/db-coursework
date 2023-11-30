<?php

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router){

    $config = require __DIR__ . '/../app/config.php';

    $basePath = isset($config['url_base']) ? $config['url_base'] : '';

    $router->get($basePath . '/logout', 'AccessController@logout');
    $router->get($basePath . '/login', 'AccessController@login');
    $router->get($basePath . '', 'HomeController@home');
    $router->get($basePath . '/{role}[/home]', 'HomeController@home');
    $router->get($basePath . '/{role}/{table}[/show]', 'TableController@show');

    $router->post($basePath . '/{role}/{table}/delete', 'TableController@delete');
    $router->post($basePath . '/auth', 'AccessController@authenticate');

});

return $dispatcher;
