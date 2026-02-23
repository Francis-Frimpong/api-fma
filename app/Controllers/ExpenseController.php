<?php
require_once __DIR__. '/../Models/Expenses.php';
require_once __DIR__. '/../Core/AuthMiddleware.php';
require_once __DIR__ . '/../Core/Response.php';


class ExpenseController{
    private Expenses $expenses;

    public function __construct()
    {
        $this->expenses = new Expenses();
    }

    public function getAllExpenses()
    {
        $user = $GLOBALS['auth_user'] = AuthMiddleware::handle();

        $expenseTable = $this->expenses->expenseData($user->id);

        $data = $expenseTable;

        Response::json($data, 200);
    }

    public function destroy($id)
    {
        $user = $GLOBALS['auth_user'] = Authmiddleware::handle();
        $data = $this->expenses->deleteData($id, $user->id);
        Response::json($data, 200);
    }
}