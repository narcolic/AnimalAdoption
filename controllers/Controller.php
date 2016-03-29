<?php
include_once '../services/viewService.php';
include_once '../services/DatabaseService.php';
include_once  '../services/loginService.php';

class Controller
{

    protected $loginService = null;
    protected $databaseService = null;
    protected $viewService = null;
    protected $view = null;
    protected $model = null;


    function __construct()
    {
        $this->loginService = null;
        $this->databaseService = new databaseService("localhost", "karakatd_db", "root", "");
        $this->databaseService->connect();
        $this->viewService = new ViewService($this->model);
    }

    function invoke()
    {
        session_start();
        $this->viewService->render(null);
    }

    function logout() {
        session_start();
        session_destroy();
        session_regenerate_id(TRUE);
        header("Location: index.php");
    }
}