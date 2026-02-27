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
        $page = max((int) ($_GET['page'] ?? 1), 1);
        $limit = max((int) ($_GET['limit'] ?? 10), 1);

        $limit = min($limit, 50);

        $offset = ($page - 1) * $limit;

        
        // Get total count
        $countSql = "SELECT COUNT(*) FROM income WHERE user_id = ?";
        $countStmt = $this->pdo->prepare($countSql);
        $countStmt->execute([$user_id]);
        $totalRecords = $countStmt->fetchColumn();

        $totalPages = ceil($totalRecords / $limit);
        
        if($totalPages < 1){
            $totalPages = 1;
        }

        $sql = "SELECT expense_date AS date, amount FROM expenses WHERE user_id = ? ORDER BY expense_date DESC LIMIT ? OFFSET ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return [
            'current_page' => $page,
            'per_page' => $limit,
            'total_records' => (int) $totalRecords,
            'total_pages' => $totalPages,
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];

    }

    public function deleteData($id, $user_id)
    {
        $sql = "DELETE FROM expenses WHERE id = ? AND user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id, $user_id]);
        return ['message' => 'Expenses data deleted'];


    }
}