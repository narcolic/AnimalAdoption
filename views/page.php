<?php

Class Page {

    public $view = null;
    public $model = null;

    function __construct($view, $model)
    {
        $this->view = $view;
        $this->model = $model;
    }
}