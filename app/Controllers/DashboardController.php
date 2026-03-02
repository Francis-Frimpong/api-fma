<?php
require_once __DIR__ . '/../Models/Dashboard.php';
require_once __DIR__ . '/../Models/MonthlySummary.php';
require_once __DIR__ . '/../Core/Response.php';
require_once __DIR__ . '/../Core/AuthMiddleware.php';


class DashboardController
{
    private Dashboard $dashboard;
    private MonthlySummary $monthlySummary;

    public function __construct()
    {
        $this->dashboard = new Dashboard();
        $this->monthlySummary = new MonthlySummary();
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

    public function monthlySummary()
    {
        $user = $GLOBALS['auth_user'] = AuthMiddleware::handle();

        $month = (int) ($_GET['month'] ?? date('m'));
        $year  = (int) ($_GET['year'] ?? date('Y'));

        if ($month < 1 || $month > 12 || $year < 1) {
            Response::json(['error' => 'Invalid month or year'], 400);
            return;
        }

        $summary = $this->monthlySummary->monthlySummary($user->id, $month, $year);

        Response::json($summary, 200);
    }
}
