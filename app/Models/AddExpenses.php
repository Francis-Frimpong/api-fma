<?php
require_once  __DIR__.'/../Database/Database.php';


class AddExpenses{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function addExpenses($user_id, $amount, $category,$date, $note)
    {
        $sql = "INSERT INTO expenses (user_id, amount,category, expense_date,note) VALUES (?,?,?,?,?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $amount, $category, $date, $note]);
    }
}