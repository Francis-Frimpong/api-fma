<?php
require_once __DIR__ .'/../Models/AddExpenses.php';
require_once __DIR__ . '/../Core/Response.php';
require_once __DIR__ . '/../Core/AuthMiddleware.php';


class AddExpensesController{
    private AddExpenses $addExpenses;

    public function __construct()
    {
        $this->addExpenses = new AddExpenses();
    }

    public function addExpensesData()
    {
        $user = $GLOBALS['auth_user'] = AuthMiddleware::handle();

        $data = json_decode(file_get_contents('php://input'), true);

        if(!$data){
            Response::json(['error' => 'Invalid JSON or empty body'], 400);
            return;
        }

        if(
            empty(trim($data['amount'])) ||
            empty(trim($data['category'])) ||
            empty(trim($data['expense_date']))
            ){
                Response::json(['error' => 'Amount, source and income_date are required'], 400);
                return;
        }

        $expense = $this->addExpenses->addExpenses($user->id, $data['amount'], $data['category'],  $data['expense_date'],$data['note'] ?? null );

        if($expense){
            Response::json(['success' => 'Expenses data added']);
        }


    }
}