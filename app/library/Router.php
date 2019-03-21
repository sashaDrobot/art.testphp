<?php

namespace app\library;

class Router
{
    protected $routes;
    protected $params;

    public function __construct()
    {
        $routesArr = include('app/routes.php');
        foreach ($routesArr as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function run()
    {
        if ($this->match()) {
            $path = 'app\controllers\\' . $this->params['controller'];
            if (class_exists($path)) {
                $action = $this->params['action'];
                if (method_exists($path, $action)) {
                    $controller = new $path();
                    $controller->$action();
                }
            }
        }
    }

    public function add($route, $params)
    {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int)$match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }
}