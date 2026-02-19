<?php
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/DashboardController.php';
require_once __DIR__ . '/../app/Controllers/IncomeController.php';

$router = new Router();

// Auth endpoint
// user registration
$router->post('/register',[AuthController::class, 'register']);

// Login user
$router->post('/login',[AuthController::class, 'login']);


// user dashboard
$router->get('/dashboard', [DashboardController::class, 'userStats'], ['auth']);

// user income data
$router->get('/income', [IncomeController::class, 'getAllIncome'], ['auth']);

// delete single income data
$router->delete('/income/{id}', [IncomeController::class, 'deleteSingleIncome'], ['auth']);


$router->dispatch();
