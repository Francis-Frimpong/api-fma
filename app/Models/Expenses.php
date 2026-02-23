<?php
require_once __DIR__.'/../Database/Database.php';

class Expenses{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function expenseData($user_id)
    {
        $sql = "SELECT expense_date AS date, amount FROM expenses WHERE user_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


}