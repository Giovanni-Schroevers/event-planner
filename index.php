<?php

/**
 * Front Controller
 * All requests are routed through this file
 */

require_once __DIR__ . '/core/Router.php';

$router = new Router();

// Define routes
$router->get('/', 'HomeController@index');
$router->get('/login', 'LoginController@index');
$router->post('/login', 'LoginController@authenticate');

// TODO: Add more routes as needed
// $router->get('/register', 'RegisterController@index');
// $router->get('/events', 'EventController@index');
// $router->get('/account', 'AccountController@index');

// Dispatch the request
$router->dispatch();
