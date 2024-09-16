<?php

require '../helpers.php';
require basePath('Router.php');
require basePath('Database.php');

// $config = require basePath('config/db.php');
// $db = new Database($config);

//Instantiating the router
$router = new Router();

//Get routes
require basePath('routes.php');

//Get current $URI and http method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

//Route the request

$router->route($uri, $method);
