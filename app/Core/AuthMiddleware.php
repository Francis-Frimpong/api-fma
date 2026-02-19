<?php
require_once __DIR__ .'/JWTHandler.php';

class Authmiddleware{
    public static function handle()
    {
        $headers = function_exists('getallheaders') ? getallheaders() : [];
        $token = null;

        if(isset($headers['X-Auth-Token'])){
            $token = $headers['X-Auth-Token'];
        } elseif(isset($_SERVER['HTTP_X_AUTH_TOKEN'])){
            $token = $_SERVER['HTTP_X_AUTH_TOKEN'];
        }

        if(!$token){
            Response::json(['error' => 'Authorization header missing'],401);
            exit;
        }

        $jwt = new JWTHandler();
        $decoded = $jwt->validateToken($token);

        if(!$decoded){
            Response::json(['error' => 'Invalid or expired token'], 401);
            exit;
        }
        
        return  $decoded->data;
    }
}