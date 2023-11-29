<?php

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router){

    $config = require __DIR__ . '/../app/config.php';

    $basePath = isset($config['url_base']) ? $config['url_base'] : '';

    $router->addRoute('GET', $basePath . '/logout', 'HomeController@logout');

    $router->addRoute('GET', $basePath . '/login', 'HomeController@login');

    $router->addRoute('POST', $basePath . '/auth', 'HomeController@authenticate');

    $router->addRoute('GET', $basePath . '', 'HomeController@home');

    //$r->addRoute('GET', $basePath.'/{role}', 'TableController@home');

    $router->addRoute('GET', $basePath . '/{role}[/home]', 'HomeController@home');

    $router->addRoute('GET', $basePath . '/{role}/{table}/delete/{id}', 'HomeController@index');

    $router->addRoute('GET', $basePath . '/{role}/{table}[/show]', 'HomeController@show');
    
    //$r->addRoute('GET', $basePath.'/{role}/{table}/show', 'HomeController@index');
    //$r->addRoute('GET', $basePath.'/{role}/{table}/{action}', 'HomeController@index');
});

return $dispatcher;
