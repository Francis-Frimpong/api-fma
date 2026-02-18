<?php
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

$router = new Router();

// Auth endpoint
// user registration
$router->post('/register',[AuthController::class, 'register']);

// Login user
$router->post('/login',[AuthController::class, 'login']);


$router->dispatch();
