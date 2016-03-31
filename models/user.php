<?php


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