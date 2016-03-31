<?php

include_once 'models/user.php';
include_once 'models/animal.php';
include_once 'models/ownRequest.php';
include_once 'models/adoptionRequests.php';
include_once 'views/page.php';
include_once 'services/viewService.php';
include_once 'services/loginService.php';

class Controller
{
    const PARAMETER_ACTION = 'action';
    const PARAMETER_USERNAME = 'username';
    const PARAMETER_PASSWORD = 'password';

    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_REGISTER = 'register';
    const ACTION_HOME = 'home';


    const SUBACTION_ADD_ANIMAL = 'add_animal';
    const SUBACTION_UPLOAD_PHOTO = 'uploaded';
    const SUBACTION_REGISTER_USER = 'register_user';

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
        //if no action is set from forms return to default page
        if (!isset($_GET[self::PARAMETER_ACTION])) {
            $this->viewService->render($this->defaultView);
            return;
        }
        //Get the action from forms
        switch ($_GET[self::PARAMETER_ACTION]) {
            case self::ACTION_LOGIN:
                $this->login();
                break;
            case self::ACTION_LOGOUT:
                $this->loginService->logout();
                break;
            case self::ACTION_REGISTER;
                var_dump($_POST[self::SUBACTION_REGISTER_USER]);
                if (isset($_POST[self::SUBACTION_REGISTER_USER])) {
                    $user = new User();
                    $user->username = isset($_POST['user_name']) ? $_POST['user_name'] : null;
                    $user->password = isset($_POST['user_password']) ? $_POST['user_password'] : null;
                    $this->loginService->register($user);
                    header("Location: index.php?action=" . self::ACTION_REGISTER);
                }
                break;
            case self::ACTION_HOME:
                if (!isset($_SESSION['user'])) {
                    $this->viewService->render($this->defaultView);
                } else {
                    //upload image file
                    var_dump($_POST[self::SUBACTION_UPLOAD_PHOTO]);
                    if (isset($_POST[self::SUBACTION_UPLOAD_PHOTO])) {
                        $file = null;
                        //get the file name from form input and move it to images folder
                        if ($_FILES["pic"]["error"] > 0) {
                            $errors[] = "Error in uploading file <br />";
                        } else {
                            $type = $_FILES["pic"]["type"];
                            //if the type is one of the three image types
                            if (($type == "image/jpeg") || ($type == "image/png") || ($type == "image/gif")) {
                                //move the file to a sub-directory called images
                                move_uploaded_file($_FILES["pic"]["tmp_name"], "images/" . $_FILES["pic"]["name"]);
                                $file = "images/" . $_FILES["pic"]["name"];
                            } else {
                                $errors[] = "Wrong File Type! Only jpeg, png and gid allowed";
                            }
                        }
                    }
                    //add a new animal to the database
                    if (isset($_POST[self::SUBACTION_ADD_ANIMAL])) {
                        $animal = new Animal();
                        $animal->name = isset($_POST['animal_name']) ? $_POST['animal_name'] : null;
                        $animal->birthdate = isset($_POST['animal_date']) ? $_POST['animal_date'] : null;
                        $animal->description = isset($_POST['animal_description']) ? $_POST['animal_description'] : null;
                        $animal->picture = isset($file) ? $file : null;
                        $operation = $this->databaseService->saveAnimal($animal);
                        header("Location: index.php?action=" . self::ACTION_HOME);
                    }
                    $this->home();
                }
                break;
            default:
                $this->viewService->render($this->defaultView);
        }
    }

    private
    function login()
    {
        //if no username and password are ser return to default page
        if (!$_POST[self::PARAMETER_USERNAME] || !$_POST[self::PARAMETER_PASSWORD]) {
            $this->viewService->render($this->defaultView);
            return;
        } else {

            $username = $_POST[self::PARAMETER_USERNAME];
            $password = $_POST[self::PARAMETER_PASSWORD];
            //login
            if ($this->loginService->login($username, $password)) {
                header("Location: index.php?action=" . self::ACTION_HOME);
            } else {
                $this->viewService->render($this->defaultView);
            }
            return;
        }

    }

    //home page constructor for staff or user
    private function home()
    {
        $user = $_SESSION['user'];
        $model = null;
        $indexkey = $user->getRole() . 'home';
        //call queries and create tables.
        if ($user->isStaff) {
            $model = array();
            $model['Animals'] = $this->databaseService->getAnimalsForAdoption();
            $model['AdoptionRequests'] = $this->databaseService->getPendingAdoptReq();
            $model['AnimalOwners'] = $this->databaseService->getAllAnimalsOwners();
        } else {
            $model = array();
            $model['Animals'] = $this->databaseService->getUserAnimals($_SESSION['user']->id);
            $model['PreviousAdoptionRequests'] = $this->databaseService->getUserAnimalRequests($_SESSION['user']->id);
            $model['AdoptionRequests'] = $this->databaseService->getUserPendReq($_SESSION['user']->id);
            $model['AllAnimals'] = $this->databaseService->getAnimalsForAdoption();
        }
        //page class is used to give correct view and model (tables/forms etc)
        $this->viewService->render(new Page($indexkey, $model));
    }


}