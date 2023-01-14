<?php
//start session
session_start();

ini_set('display_errors', true);
error_reporting(E_ALL);




require_once "../vendor/autoload.php";
require_once "./bootstrap/database.php";

/* NEW: require the router  */
require_once "./bootstrap/router.php";

$controllerName = $route['controller'] . 'Controller';

require_once __DIR__ . '/controller/' . $controllerName . ".php";

$controllerObj = new $controllerName();
$controllerObj->route = $route;
$controllerObj->filter();
$controllerObj->render();
