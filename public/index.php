<?php

require '../helpers.php';
require basePath('router.php');


$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$router = new Router();

require basePath('routes.php');



$router->route($uri, $method);
