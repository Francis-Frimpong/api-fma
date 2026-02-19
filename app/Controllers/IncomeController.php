<?php
require_once __DIR__ . '/../Models/Income.php';
require_once __DIR__ . '/../Core/Response.php';
require_once __DIR__ . '/../Core/AuthMiddleware.php';

class IncomeController{
    private Income $income;

    public function __construct()
    {
        $this->income = new Income();
    }

    public function getAllIncome()
    {
        $user = $GLOBALS['auth_user'] = AuthMiddleware::handle();

        $incomeTable = $this->income->IncomeData($user->id);
        
        $data = $incomeTable;

        Response::json($data, 200);
    }

    public function deleteSingleIncome($id)
    {
        $user = $GLOBALS['auth_user'] = AuthMiddleware::handle();
        $data = $this->income->deleteIncomeData($id, $user->id);

        Response::json($data, 200);

    }
}