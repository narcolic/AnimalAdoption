<?php

/**
 * Created by PhpStorm.
 * User: StBoz
 * Date: 29/3/2016
 * Time: 11:09 μμ
 */
Class User
{

    public $id = -1;
    public $isStaff = false;
    public $password = '';
    public $username = 'Guest';

    function __construct()
    {
    }

    public function getRole()
    {
        if($this->id == -1)
            return '';
        
        if($this->isStaff)
            return 'staff';
        else
            return 'user';

    }
}