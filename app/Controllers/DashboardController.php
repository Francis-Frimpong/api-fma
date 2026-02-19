<?php
require_once __DIR__ . '/../Models/Dashboard.php';
require_once __DIR__ . '/../Core/Response.php';
require_once __DIR__ . '/../Core/AuthMiddleware.php';


class DashboardController
{
    private Dashboard $dashboard;

    public function __construct()
    {
        $this->dashboard = new Dashboard();
    }

    public function userStats()
    {
        $user = $GLOBALS['auth_user'] = AuthMiddleware::handle();

        $totalIncome = $this->dashboard->totalIncome($user->id);
        $totalExpenses =$this->dashboard->totalExpense($user->id);
        $balance = $this->dashboard->balance($user->id);

        $data = [
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'balance' => $balance
        ];

        Response::json($data, 200);
    }
}