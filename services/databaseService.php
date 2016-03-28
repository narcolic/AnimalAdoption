<?php

class DatabaseService {

    private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;

    private $errors = array();

    function __construct()
    {

    }

    public function connect() {
        try{
            $this->pdo = new PDO("mysql:host=$this->server;dbname=$this->dbname", "$this->username", "$this->password");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            array_push($ex->getMessage(), $this->errors);
        }
    }
}