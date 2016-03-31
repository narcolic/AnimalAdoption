<?php
include_once 'services/DatabaseService.php';
include_once 'services/viewService.php';
include_once 'models/user.php';

class LoginService
{
    protected $user = null;
    protected $databaseService = null;

    function __construct()
    {
        $this->databaseService = new databaseService("localhost", "karakatd_db", "root", "");
        $this->databaseService->connect();
    }

    public function login($username, $password)
    {
        $this->user = $this->databaseService->getUserByUsername($username);
        if ($this->user->password == $password) {
            $_SESSION['user'] = $this->user;
            return true;
        }
        return false;
    }


    function logout()
    {
        session_destroy();
        session_regenerate_id(true);
        header("Location: index.php");
    }

    public function register($user)
    {
        if ($this->databaseService->isUserAvail($user->username)) {
            $this->databaseService->saveUser($user);
        }
        else{
            echo "Username already exists!";
            
        }
    }
}