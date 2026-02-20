<?php
require_once __DIR__ .'/../Models/AddIncome.php';
require_once __DIR__ . '/../Core/Response.php';
require_once __DIR__ . '/../Core/AuthMiddleware.php';

class AddIncomeController{
    private AddIncome $addIncome;

    public function __construct()
    {
        $this->addIncome = new AddIncome();
    }

    public function addIncomeData()
    {
        $user = $GLOBALS['auth_user'] = AuthMiddleware::handle();

        $data = json_decode(file_get_contents('php://input'), true);

        if(!$data){
            Response::json(['error' => 'Invalid JSON or empty body'], 400);
            return;
        }

        if(
            empty(trim($data['amount'])) ||
            empty(trim($data['source'])) ||
            empty(trim($data['income_date']))
            ){
                Response::json(['error' => 'Amount, source and income_date are required'], 400);
                return;
            }

        $income = $this->addIncome->addIncome($user->id, $data['amount'], $data['source'], $data['note'] ?? null, $data['income_date']);

        if($income){
            Response::json(['success' => 'Income data added']);
        }

    }
}