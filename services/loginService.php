<?php
include_once '../services/DatabaseService.php';
include_once '../services/viewService.php';

class LoginService
{
    protected $user = null;
    protected $databaseService = null;
    protected $viewService;

    function __construct()
    {
        $this->databaseService = new databaseService("localhost", "karakatd_db", "root", "");
        $this->databaseService->connect();
        $this->viewService = new ViewService($this->model);
    }

    public function login($name, $password)
    {
        session_start();

        if (isset($_GET["logout"])) {
            $this->logout();
        } elseif (isset($_SESSION['id'])) {
            //if session variable id is set, display page
            $this->viewService->render();
        } elseif (isset($_POST['login'])) {
            //if user submit login form, get account from model
            print_r($_REQUEST);
            $account = $this->model->getAccountById($_POST["id"]);

            //Set SESSION variables.
            if ($account != null) {
                $_SESSION["id"] = $account->getId();
                header("Location: index.php");
            }else {
                echo "<p>Invalid username</p>";
                $this->viewService->displayPage("login");
            }
        } else {
            //display login page
            $this->viewService->displayPage("login");
        }
    }


    function logout() {
        session_start();
        session_destroy();
        session_regenerate_id(TRUE);
        header("Location: index.php");
    }
}