<?php
include_once '../services/viewService.php';
include_once  '../services/loginService.php';

class Controller
{

    protected $loginService = null;
    protected $viewService = null;
    protected $view = null;
    protected $model = null;


    function __construct()
    {
        $this->loginService = new LoginService();
        //$this->viewService = new ViewService($this->model);
    }

    function invoke()
    {
        session_start();
        //$this->viewService->render();
    }
    
}