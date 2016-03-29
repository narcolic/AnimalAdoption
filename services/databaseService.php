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

    public function getUserByUsername($username)
    {
        $query = "select * from user where username = '" . $username . "'" ;
        $user = new User();
        try {
            $rows = $this->pdo-> query($query);
            if ($rows && $rows->rowCount() ==1) {
                $row=$rows->fetch();
                $user->username = $row['username'];
                $user->id = $row['userID'];
                $user->password = $row['password'];
                $user->isStaff = $row['staff'];
            }
        } catch (PDOException $ex) {
            array_push($ex->getMessage(), $this->errors);
        }
        return $user;
    }

    public function getAnimalsForAdoption()
    {
        $query = "select * from animal where available = 1";
        $animals = array();
        try {
            $rows = $this->pdo-> query($query);
            if ($rows && $rows->rowCount() >= 1) {
                $animalsArray = $rows->fetchAll();
                foreach ($animalsArray as $a)
                {
                    $animal = new Animal();
                    $animal->id = $a['animalID'];
                    $animal->name = $a['name'];
                    $animal->birthdate = $a['dateofbirth'];
                    $animal->description = $a['description'];
                    $animal->picture = $a['photo'];
                    $animal->isAvailable = $a['available'];
                    array_push($animals, $animal);
                }
            }
        } catch (PDOException $ex) {
            array_push($ex->getMessage(), $this->errors);
        }
        return $animals;
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