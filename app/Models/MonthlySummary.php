<?php
require_once __DIR__ .'/../Database/Database.php';

class MonthlySummary{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function monthlySummary($user_id, $month, $year)
    {
        $startDate = date('Y-m-01', strtotime("$year-$month-01"));
        $endDate   = date('Y-m-t', strtotime($startDate));

        // Income
        $incomeSql = "SELECT SUM(amount) FROM income
                    WHERE user_id = ?
                    AND income_date BETWEEN ? AND ?";

        $incomeStmt = $this->pdo->prepare($incomeSql);
        $incomeStmt->execute([$user_id, $startDate, $endDate]);
        $totalIncome = $incomeStmt->fetchColumn() ?? 0;

        // Expenses
        $expenseSql = "SELECT SUM(amount) FROM expenses
                    WHERE user_id = ?
                    AND expense_date BETWEEN ? AND ?";

        $expenseStmt = $this->pdo->prepare($expenseSql);
        $expenseStmt->execute([$user_id, $startDate, $endDate]);
        $totalExpenses = $expenseStmt->fetchColumn() ?? 0;

        $totalIncome = (float) $totalIncome;
        $totalExpenses = (float) $totalExpenses;

        return [
            'month' => "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT),
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'balance' => $totalIncome - $totalExpenses
        ];
    }
}