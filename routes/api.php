<?php
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/DashboardController.php';
require_once __DIR__ . '/../app/Controllers/IncomeController.php';
require_once __DIR__ . '/../app/Controllers/AddIncomeController.php';
require_once __DIR__ . '/../app/Controllers/ExpenseController.php';
require_once __DIR__ . '/../app/Controllers/AddExpensesController.php';

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

// add income data
$router->post('/addIncome', [AddIncomeController::class, 'addIncomeData'], ['auth']);

// delete single income data
$router->delete('/income/{id}', [IncomeController::class, 'deleteSingleIncome'], ['auth']);


// user expenses data
$router->get('/expenses', [ExpenseController::class, 'getAllExpenses'], ['auth']);

// add expenses data
$router->post('/addExpenses', [AddExpensesController::class, 'addExpensesData'], ['auth']);

// delete single expenses data
$router->delete('/expenses/{id}', [ExpenseController::class, 'destroy'], ['auth']);


$router->dispatch();
