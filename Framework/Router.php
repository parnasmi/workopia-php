<?php

namespace Framework;

class Router {
    protected $routes = [];

    public function regiterRoute(string $method, string $uri, string  $action): void {

        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }


    /**
     * Add a GET route
     *
     * @param string $uri;
     * @param string $controller;
     * @return void
     */
    public function get(string $uri, string $controller): void {
        $this->regiterRoute('GET', $uri, $controller);
    }

    /**
     * Add a POST route
     *
     * @param string $uri;
     * @param string $controller;
     * @return void
     */
    public function post(string $uri, string $controller): void {
        $this->regiterRoute('POST', $uri, $controller);
    }

    /**
     * Add a PUT route
     *
     * @param string $uri;
     * @param string $controller;
     * @return void
     */
    public function put(string $uri, string $controller): void {
        $this->regiterRoute('PUT', $uri, $controller);
    }

    /**
     * Add a DELETE route
     *
     * @param string $uri;
     * @param string $controller;
     * @return void
     */
    public function delete(string $uri, string $controller): void {
        $this->regiterRoute('DELETE', $uri, $controller);
    }


    /**
     * Load error page
     * 
     * @param int $httpStatusCode
     * @return void
     */

    public function error(int $httpStatusCode = 404): void {
        http_response_code($httpStatusCode);
        loadView("error/{$httpStatusCode}");
        exit;
    }


    /**
     * Route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void;
     */

    public function route(string $uri, string $method): void {
        foreach ($this->routes as $route) {
            if ($uri === $route['uri'] && $method === $route['method']) {

                //Extract Controller and controller method
                $controller = 'App\\Controllers\\' . $route['controller'];
                $controllerMethod = $route['controllerMethod'];

                // Instantiate the controller and call the method;
                $controllerInstance = new $controller();
                $controllerInstance->$controllerMethod();
                return;
            }
        }
        $this->error();
    }
}
