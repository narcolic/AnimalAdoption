<?php
include_once 'services/viewService.php';

class Controller {
    
    protected $loginService = null;
    protected $viewService = null;
    protected $view = null;
    protected $model = null;
    
    
    function __construct()
    {
        $this->loginService = null;
        $this->viewService = new ViewService($this->model);
    }

    function invoke() {
        session_start();
        $this->viewService->render(null);
    }
}