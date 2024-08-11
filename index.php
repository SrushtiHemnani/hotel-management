<?php
require_once 'vendor/autoload.php';
require "bootstrap/bootstrap.php";

$uri = trim($_SERVER['REQUEST_URI'], '/');
if ($uri == "") $uri = "/";
$routes = require_once 'routes/route.php';
/// Check if session is already started
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// auth middleware

if(!in_array($uri, ['login', 'signup']) && !isset($_SESSION['user_id'])) {
	header('Location: /login');
	exit;
}


if (array_key_exists($uri, $routes)) {
	
	$controllerInfo = $routes[ $uri ];
	$controllerClass = $controllerInfo[0];
	$methodName = $controllerInfo[1];
	
	if (class_exists($controllerClass)) {
		$controller = new $controllerClass();
		if (method_exists($controller, $methodName)) {
			$controller->$methodName();
		} else {
			echo "Method does not exist.";
		}
	} else {
		echo "Controller does not exist.";
	}
} else {
	echo "404 Not Found";
}
