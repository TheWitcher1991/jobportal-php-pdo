<?php

namespace Core;

use core\Singleton;

class Router {

    use Singleton;

    private $routes = [];

    public function add($pattern, $callback) {
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
        $this->routes[$pattern] = $callback;
    }

    public function execute($url) {
        foreach($this->routes as $pattern => $callback) {
            if (preg_match($pattern, $url, $params)) {
                array_shift($params);
                return call_user_func_array($callback, array_values($params));
            }
        }
    }

    public function autoLoadClass() {
        spl_autoload_register(function ($class) {
            $path = str_replace('\\', '/', $class . '.php');
            if (file_exists($path)) {
                require_once $path;
            }
        });
    }

}