<?php
require_once __DIR__ . '/../Database/Database.php';


class Income{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function IncomeData($user_id)
    {
        $sql = "SELECT income_date AS 'date', source, amount FROM income WHERE user_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteIncomeData($id, $user_id)
    {
        $sql = "DELETE FROM income WHERE id = ? AND user_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id, $user_id]);

        return ['message' => 'Income data deleted'];

    }
}