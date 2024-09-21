<?php

namespace Framework;

use App\Controllers\ErrorController;

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

    public function route(string $uri): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === "POST" && isset($_POST['_method'])) {
            //Overriding request method with the value of _method
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {

            //Split the current URI into segments
            $uriSegments = explode('/', trim($uri, '/'));

            //Split the current route URI into segments
            $routeSegments = explode('/', trim($route['uri'], '/'));

            $match = true;

            // Check if the number of segements matches

            if (count($uriSegments) === count($routeSegments) && strtoupper($route['method'] === $requestMethod)) {
                $params = [];

                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
                    //If the uri's don't match and there is no param
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }

                    //todo: learn out there what does preg_match do?
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }

                if ($match) {
                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    // Instantiate the controller and call the method;
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }

        ErrorController::notFound();
    }
}
