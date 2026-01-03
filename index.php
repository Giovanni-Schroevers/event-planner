<?php

/**
 * Front Controller
 * All requests are routed through this file
 */

// Load classes that may be stored in session BEFORE session_start()
require_once __DIR__ . '/model/dto/UserSessionDTO.php';

session_start();

require_once __DIR__ . '/core/Router.php';

$router = new Router();

// Define routes
$router->get('/', 'HomeController@index');
$router->get('/login', 'LoginController@index');
$router->post('/login', 'LoginController@authenticate');
$router->get('/logout', 'LogoutController@index');

// TODO: Add more routes as needed
$router->get('/register', 'RegisterController@index');
$router->post('/register', 'RegisterController@register');
// $router->get('/events', 'EventController@index');
// $router->get('/account', 'AccountController@index');

// Dispatch the request
$router->dispatch();
