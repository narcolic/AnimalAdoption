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
//
//        if (isset($_GET["logout"])) {
//            $this->logout();
//        } elseif (isset($_SESSION['id'])) {
//            //if session variable id is set, display page
//            $this->viewService->render();
//        } elseif (isset($_POST['login'])) {
//            //if user submit login form, get account from model
//            print_r($_REQUEST);
//            $account = $this->model->getAccountById($_POST["id"]);
//
//            //Set SESSION variables.
//            if ($account != null) {
//                $_SESSION["id"] = $account->getId();
//                header("Location: index.php");
//            }else {
//                echo "<p>Invalid username</p>";
//                $this->viewService->displayPage("login");
//            }
//        } else {
//            //display login page
//            $this->viewService->displayPage("login");
//        }
    }


    function logout()
    {
        session_destroy();
        session_regenerate_id(true);
        header("Location: index.php");
    }

    public function register()
    {

    }
}