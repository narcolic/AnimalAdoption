<?php

class DatabaseService
{

    private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
    private $errors = array();

    function __construct($server, $dbname, $username, $password)
    {
        $this->pdo = null;
        $this->server = $server;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->server;dbname=$this->dbname", "$this->username", "$this->password");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            array_push($ex->getMessage(), $this->errors);
        }
    }

    public function getPendingAdoptReq() {
        $query = "select animalID,name,dateofbirth,description,photo from animal where available = TRUE ";
        try {
            $rows = $this->pdo-> query($query);
            if ($rows && $rows->rowCount() ==1) {
                $row=$rows->fetch();
                $animalarray = array($row['animalID'],$row['name'],$row['dateofbirth'],$row['description'],$row['photo']);
                return $animalarray;
            }
            else return null;
        } catch (PDOException $ex) {
            array_push($ex->getMessage(), $this->errors);
        }
    }

    public function allAdoptReq() {
        $query = "select animalID,name,dateofbirth,description,photo from animal where animalID = (SELECT animalID from adoptionrequest WHERE approved IS NOT NULL ) ";
        try {
            $rows = $this->pdo-> query($query);
            if ($rows && $rows->rowCount() ==1) {
                $row=$rows->fetch();
                $animalarray = array($row['animalID'],$row['name'],$row['dateofbirth'],$row['description'],$row['photo']);
                return $animalarray;
            }
            else return null;
        } catch (PDOException $ex) {
            array_push($ex->getMessage(), $this->errors);
        }
    }

    public function userPendingAdoptReq($id) {
        $query = "select animalID,name,dateofbirth,description,photo from animal where animalID = (SELECT animalID from adoptionrequest WHERE userID = '$id' AND approved IS NULL ) ";
        try {
            $rows = $this->pdo-> query($query);
            if ($rows && $rows->rowCount() ==1) {
                $row=$rows->fetch();
                $animalarray = array($row['animalID'],$row['name'],$row['dateofbirth'],$row['description'],$row['photo']);
                return $animalarray;
            }
            else return null;
        } catch (PDOException $ex) {
            array_push($ex->getMessage(), $this->errors);
        }
    }

    public function userOwnedAnimals($id) {
        $query = "select animalID,name,dateofbirth,description,photo from animal where animalID =(SELECT animalID FROM owns where userID = '$id') ";
        try {
            $rows = $this->pdo-> query($query);
            if ($rows && $rows->rowCount() ==1) {
                $row=$rows->fetch();
                $animalarray = array($row['animalID'],$row['name'],$row['dateofbirth'],$row['description'],$row['photo']);
                return $animalarray;
            }
            else return null;
        } catch (PDOException $ex) {
            array_push($ex->getMessage(), $this->errors);
        }
    }
}