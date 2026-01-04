<?php

/**
 * Front Controller
 * All requests are routed through this file
 */

require_once __DIR__ . '/model/dto/UserSessionDTO.php';

session_start();

require_once __DIR__ . '/core/Router.php';

$router = new Router();

// Define routes
$router->get('/', 'HomeController@index');
$router->get('/login', 'LoginController@index');
$router->post('/login', 'LoginController@authenticate');
$router->get('/logout', 'LogoutController@index');
$router->get('/register', 'RegisterController@index');
$router->post('/register', 'RegisterController@register');
$router->get('/events', 'EventController@index');
$router->get('/events/create', 'EventController@create');
$router->post('/events/create', 'EventController@store');
$router->get('/events/{id}', 'EventController@show');
$router->post('/events/{id}/register', 'EventController@register');
$router->post('/events/{id}/deregister', 'EventController@deregister');
$router->get('/events/{id}/edit', 'EventController@edit');
$router->post('/events/{id}/edit', 'EventController@update');
$router->post('/events/{id}/participants/{userId}/remove', 'EventController@removeParticipant');
$router->get('/account', 'AccountController@index');
$router->post('/account/update', 'AccountController@update');
$router->post('/account/delete', 'AccountController@delete');

$router->dispatch();
