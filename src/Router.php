<?php

namespace Router;

class Router {
    private $routes = [
        'get' => [],
        'post' => [],
        'put' => [],
        'delete'
    ];

    public function __call($name, $arguments) {
        // only two arguments passed
        if (count($arguments) != 2){
            throw new \Exception('Required arguments $uri and $callback not provided');
        }
        // first argument is uri (string)
        if (!is_string($arguments[0])) {
            throw new \Exception('First argument $uri must be of type string');
        }
        // second argument is callback
        if (!is_callable($arguments[1])){
            throw new \Exception('Second argument $callback must a callback');
        }
        $this->routes[$name][$arguments[0]] = $arguments[1];
    }

    public function run($method, $uri) {
        return call_user_func($this->routes[$method][$uri]);
    }
}
