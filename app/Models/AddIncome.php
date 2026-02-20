<?php
require_once __DIR__ .'/../Database/Database.php';

class AddIncome{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function addIncome($user_id, $amount, $source, $note, $incomeDate)
    {
        $sql = "INSERT INTO income (user_id, amount, source, note, income_date) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $amount, $source, $note, $incomeDate]);
    }
}