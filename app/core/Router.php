<?php

namespace App\Core;

class Router
{

    public static function run($dispatcher)
    {
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
            case \FastRoute\Dispatcher::NOT_FOUND:
                echo '404 Not Found';
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                echo '405 Method Not Allowed';
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                list($controllerClass, $method) = explode('@', $handler);

                $controllerClass = "\\App\\Controllers\\" . $controllerClass;
                $controller = new $controllerClass;

                call_user_func_array([$controller, $method], $vars);
                break;
        }
    }
}
