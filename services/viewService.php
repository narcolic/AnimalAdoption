<?php


class ViewService
{

    const ViewsPath = 'views/';
    protected $defaultViews = array(
        'header' => 'header.php',
        'menu' => 'menu.php',
        'footer' => 'footer.php'
    );


    public $page = null;
    public $model = null;


    function __construct($model)
    {
        $this->model = $model;
    }

    function render()
    {
        $this->displayPage("header");
        if (!isset($_GET["page"])) {
            $this->page = "index.php";
        } else {
            if (!$_SESSION['credential']) {
                $this->page = "views/user/" . $_GET["page"] . ".php";
            }
            else{
                $this->page = "views/staff/" . $_GET["page"] . ".php";
            }
        }

        require_once($this->page);

        $this->displayPage("footer");
    }

    protected function displayPage($page)
    {
        if ($this->isDefaultPage($page)) {
            $this->page = self::ViewsPath . $this->defaultViews[$page];
        } else {
            $this->page = self::ViewsPath . $page . ".php";
        }
        require($this->page);
    }

    private function isDefaultPage($pageShortcut)
    {
        return array_key_exists($pageShortcut, $this->defaultViews);
    }

}