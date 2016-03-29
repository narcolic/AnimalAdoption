<?php
include_once '../services/DatabaseService.php';

class LoginService
{
    protected $user = null;
    protected $databaseService = null;

    function __construct()
    {
        $this->databaseService = new databaseService("localhost", "karakatd_db", "root", "");
        $this->databaseService->connect();
    }

    public function login($name, $password)
    {
        
    }


    function logout() {
        session_start();
        session_destroy();
        session_regenerate_id(TRUE);
        header("Location: index.php");
    }
}