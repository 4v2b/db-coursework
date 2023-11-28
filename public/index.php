<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$basePath = '/db-coursework/public';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) use($basePath) {

    //$r->addRoute('POST', $basePath.'/user', 'Controller@user');
    //$r->addRoute('GET', $basePath.'/home', 'Controller@index');
    //$r->addRoute('GET', $basePath.'/greet/{name}', 'Controller@greet');
    
    $r->addRoute('GET', $basePath.'/login', 'HomeController@login');
    $r->addRoute('GET', $basePath.'/logout', 'HomeController@logout');

    $r->addRoute('POST', $basePath.'/auth', 'HomeController@authenticate');

    //$r->addRoute('GET', $basePath.'/home', 'HomeController@index');

    $r->addRoute('GET', $basePath.'', 'HomeController@login');

    //$r->addRoute('GET', $basePath.'/{role}', 'TableController@home');
    $r->addRoute('GET', $basePath.'/{role}[/home]', 'HomeController@home');
    $r->addRoute('GET', $basePath.'/{role}/{table}/delete/{id}', 'HomeController@index');

    $r->addRoute('GET', $basePath.'/{role}/{table}[/show]', 'HomeController@show');

    //$r->addRoute('GET', $basePath.'/{role}/{table}/show', 'HomeController@index');
    //$r->addRoute('GET', $basePath.'/{role}/{table}/{action}', 'HomeController@index');
    //$r->addRoute('GET', $basePath.'', 'HomeController@index');
});

// Fetch method and URI from the environment
$httpMethod = $_SERVER['REQUEST_METHOD'];

$uri = $_SERVER['REQUEST_URI'];

// Strip query string and trim trailing slash
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$uri = rtrim($uri, '/');

// Dispatch the request
 $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
// Handle the route result

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($controllerClass, $method) = explode('@', $handler);

        $controllerClass = "\\App\\Controllers\\" . $controllerClass;
        $controller = new $controllerClass;

        call_user_func_array([$controller, $method], $vars);
        break;
}
