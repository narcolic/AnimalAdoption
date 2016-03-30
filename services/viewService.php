<?php

include_once 'views/page.php';

class ViewService
{

    const ViewsPath = 'views/';
    protected $defaultViews = array(
        'header' => 'header.php',
        'menu' => 'menu.php',
        'footer' => 'footer.php',
        'intro' => 'home.php',
    );

    protected $staffViews = array(
        'staffhome' => 'home.php',
    );

    protected $userViews = array(
        'userhome' => 'home.php',
    );

    public $page = null;
    public $headerModel = null;
    public $view = null;


    function __construct()
    {
    }

    function render($page)
    {
        $this->page = $page;
        if(isset($_SESSION['user']))
        {
            $this->headerModel =array();
            $this->headerModel['user'] = $_SESSION['user'];

        }
        else{
            $this->headerModel = null;
        }
        $this->displayPage(new Page("header",null));
        if (!isset($page->view)) {
            $this->displayPage(new Page("intro",null));
        }
        else
        {

            $this->displayPage($page);
        }
//        if (!isset($_GET["page"])) {
//            $this->page = "index.php";
//        } else {
//            if (!$_SESSION['credential']) {
//                $this->page = "views/user/" . $_GET["page"] . ".php";
//            }
//            else{
//                $this->page = "views/staff/" . $_GET["page"] . ".php";
//            }
//        }


        $this->displayPage(new Page("footer",null));
    }

    private function displayPage($page)
    {
        if ($this->isDefaultPage($page->view)) {
            $this->view = self::ViewsPath . $this->defaultViews[$page->view];
        } elseif ($this->isStaffPage($page->view)) {

            $this->view = self::ViewsPath . 'staff/' . $this->staffViews[$page->view];
        } elseif($this->isUserPage($page->view))
        {
            $this->view = self::ViewsPath . 'user/' . $this->userViews[$page->view];
        }
        require($this->view);
    }

    private function isDefaultPage($pageShortcut)
    {
        return array_key_exists($pageShortcut, $this->defaultViews);
    }


    private function isStaffPage($pageShortcut)
    {
        return array_key_exists($pageShortcut, $this->staffViews);
    }


    private function isUserPage($pageShortcut)
    {
        return array_key_exists($pageShortcut, $this->userViews);
    }



}