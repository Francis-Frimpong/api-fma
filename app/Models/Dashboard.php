<?php
require_once __DIR__ . '/../Database/Database.php';

class Dashboard{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function totalIncome($user_id)
    {
        $sql = "SELECT SUM(amount) AS total_income FROM income WHERE user_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetch();

        return $result['total_income'] ?? 0;
    }

    public function totalExpense($user_id)
    {
         $sql = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE user_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetch();

        return $result['total_expenses'] ?? 0;
    }

    public function balance($user_id)
    {
        $totalIncome = $this->totalIncome($user_id);
        $totalExpenses = $this->totalExpense($user_id);

         return $totalIncome - $totalExpenses;
         
    }
}