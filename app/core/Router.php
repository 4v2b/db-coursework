<?php

namespace App\Core;

class Router{
    protected $routes = [];

    private $basePath = '';

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    public function get($uri, $controller)
    {
        $this->routes['GET'][$this->basePath.$uri] = $controller;
    }


    public function post($uri, $controller)
    {
        $this->routes['POST'][$this->basePath.$uri] = $controller;
    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$uri])) {
            $this->callAction(...explode('@', $this->routes[$method][$uri]));
        } else {
            echo "404 Not Found";
        }
    }

    public function show(){
        foreach($this->routes['GET'] as $key => $route){
            echo $key."\n";
        }
    }

    protected function callAction($controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";
        $controllerInstance = new $controller();
        $controllerInstance->$action();
    }
}


?>