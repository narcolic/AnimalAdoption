<?php

include_once  'models/user.php';
include_once  'models/animal.php';
include_once ('models/adoptionRequests.php');
include_once ('models/ownRequest.php');
include_once 'views/page.php';
include_once 'services/viewService.php';
include_once 'services/loginService.php';

class Controller
{
    const PARAMETER_ACTION = 'action';
    const PARAMETER_USERNAME = 'username';
    const PARAMETER_PASSWORD = 'password';

    const ACTION_LOGIN = 0;
    const ACTION_LOGOUT = 1;
    const ACTION_REGISTER = 2;

    protected $loginService = null;
    protected $databaseService = null;
    protected $viewService = null;
    protected $view = null;
    protected $model = null;
    protected $defaultView = null;


    function __construct()
    {
        $this->loginService = new LoginService();
        $this->viewService = new ViewService();
        $this->defaultView = new Page(null, null);
        $this->databaseService = new DatabaseService('localhost', 'karakatd_db', 'root', '');
        $this->databaseService->connect();
    }

    function invoke()
    {

        if (!isset($_POST[self::PARAMETER_ACTION])) {
            $this->viewService->render($this->defaultView);
            return;
        }
        switch ($_POST[self::PARAMETER_ACTION]) {
            case self::ACTION_LOGIN:
                $this->login();
                break;
            case self::ACTION_LOGOUT:
                $this->loginService->logout();
                break;
            case self::ACTION_REGISTER;
                
                break;
            default:
                $this->viewService->render($this->defaultView);
        }
    }

    private function login()
    {
        if (!$_POST[self::PARAMETER_USERNAME] || !$_POST[self::PARAMETER_PASSWORD]) {
            $this->viewService->render($this->defaultView);
            return;
        } else {

            $username = $_POST[self::PARAMETER_USERNAME];
            $password = $_POST[self::PARAMETER_PASSWORD];
            if ($this->loginService->login($username, $password)) {
                $user = $_SESSION['user'];
                $model = null;
                $indexkey = $user->getRole().'home';
                if($user->isStaff)
                {
                    $model = array();
                    $model['Animals'] = $this->databaseService->getAnimalsForAdoption();
                    $model['AdoptionRequests'] = $this->databaseService->getPendingAdoptReq();
                    $model['AnimalOwners'] = $this->databaseService->getAllAnimalsOwners();
                    
                }
                else
                {
                    $model = array();
                    $model['Animals'] = $this->databaseService->getUserAnimals($_SESSION['user']->id);
                    $model['PreviousAdoptionRequests'] = $this->databaseService->getUserAnimalRequests($_SESSION['user']->id);
                    $model['AdoptionRequests'] = $this->databaseService->getUserPendReq($_SESSION['user']->id);
                    $model['AllAnimals'] = $this->databaseService->getAnimalsForAdoption();
                }
                $this->viewService->render(new Page($indexkey, $model));
            } else {
                $this->viewService->render($this->defaultView);
            }
            return;
        }

    }


}