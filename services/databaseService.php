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
            array_push($this->errors, $ex->getMessage());
        }
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM user WHERE username = '" . $username . "'";
        $user = new User();
        try {
            $rows = $this->pdo->query($query);
            if ($rows && $rows->rowCount() == 1) {
                $row = $rows->fetch();
                $user->username = $row['username'];
                $user->id = $row['userID'];
                $user->password = $row['password'];
                $user->isStaff = $row['staff'];
            }
        } catch (PDOException $ex) {
            array_push($this->errors, $ex->getMessage());
        }
        return $user;
    }

    public function getAnimalsForAdoption()
    {
        $query = "SELECT * FROM animal WHERE available = 1";
        $animals = array();
        try {
            $rows = $this->pdo->query($query);
            if ($rows && $rows->rowCount() >= 1) {
                $animalsArray = $rows->fetchAll();
                foreach ($animalsArray as $a) {
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
            array_push($this->errors, $ex->getMessage());
        }
        return $animals;
    }

    public function saveAnimal($animal)
    {
        $query = "INSERT INTO animal(name,
            dateofbirth,
            description,
            photo,
            available) VALUES (
            :name, 
            :dateofbirth, 
            :description, 
            :photo,
            1)";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':name', $animal->name, PDO::PARAM_STR);
        $stmt->bindParam(':dateofbirth', $animal->birthdate, PDO::PARAM_STR);
        $stmt->bindParam(':description', $animal->description, PDO::PARAM_STR);
        $stmt->bindParam(':photo', $animal->picture, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getPendingAdoptReq()
    {
        $query = "SELECT * FROM (animal INNER JOIN adoptionrequest ON animal.animalID = adoptionrequest.animalID) INNER JOIN user ON user.userID = adoptionrequest.userID WHERE approved IS NULL ";
        $animals = array();
        try {
            $rows = $this->pdo->query($query);
            if ($rows && $rows->rowCount() >= 1) {
                $animalsArray = $rows->fetchAll();
                foreach ($animalsArray as $a) {
                    $adoptReq = new AdoptionRequests();
                    $adoptReq->adid = $a['adoptionID'];
                    $adoptReq->uid = $a['userID'];
                    $adoptReq->uname = $a['username'];
                    $adoptReq->aid = $a['animalID'];
                    $adoptReq->aname = $a['name'];
                    $adoptReq->isApproved = $a['approved'];
                    $adoptReq->birthdate = $a['dateofbirth'];
                    $adoptReq->description = $a['description'];
                    $adoptReq->picture = $a['photo'];
                    $adoptReq->isAvailble = $a['available'];
                    array_push($animals, $adoptReq);
                }
            }
        } catch (PDOException $ex) {
            array_push($this->errors, $ex->getMessage());
        }
        return $animals;
    }

    public function allAdoptReq()
    {
        $query = "SELECT animalID,name,dateofbirth,description,photo FROM animal WHERE animalID = (SELECT animalID FROM adoptionrequest WHERE approved IS NOT NULL ) ";
        try {
            $rows = $this->pdo->query($query);
            if ($rows && $rows->rowCount() == 1) {
                $row = $rows->fetch();
                $animalarray = array(
                    $row['animalID'],
                    $row['name'],
                    $row['dateofbirth'],
                    $row['description'],
                    $row['photo']
                );
                return $animalarray;
            } else {
                return null;
            }
        } catch (PDOException $ex) {
            array_push($this->errors, $ex->getMessage());
        }
    }

    public function getUserPendReq($id)
    {
        $query = "SELECT * FROM (animal INNER JOIN adoptionrequest ON animal.animalID = adoptionrequest.animalID) INNER JOIN user ON user.userID = adoptionrequest.userID WHERE approved IS NULL AND adoptionrequest.userID='" . $id . "'";
        $animals = array();
        try {
            $rows = $this->pdo->query($query);
            if ($rows && $rows->rowCount() >= 1) {
                $animalsArray = $rows->fetchAll();
                foreach ($animalsArray as $a) {
                    $adoptReq = new AdoptionRequests();
                    $adoptReq->adid = $a['adoptionID'];
                    $adoptReq->uid = $a['userID'];
                    $adoptReq->uname = $a['username'];
                    $adoptReq->aid = $a['animalID'];
                    $adoptReq->aname = $a['name'];
                    $adoptReq->isApproved = $a['approved'];
                    $adoptReq->birthdate = $a['dateofbirth'];
                    $adoptReq->description = $a['description'];
                    $adoptReq->picture = $a['photo'];
                    $adoptReq->isAvailble = $a['available'];
                    array_push($animals, $adoptReq);
                }
            }
        } catch (PDOException $ex) {
            array_push($this->errors, $ex->getMessage());
        }
        return $animals;
    }

    public function getUserAnimals($userid)
    {
        $query = "SELECT * FROM (animal INNER JOIN owns ON animal.animalID = owns.animalID) WHERE owns.userID = '" . $userid . "'";
        $animals = array();
        try {
            $rows = $this->pdo->query($query);
            if ($rows && $rows->rowCount() >= 1) {
                $animalsArray = $rows->fetchAll();
                foreach ($animalsArray as $a) {
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
            array_push($this->errors, $ex->getMessage());
        }
        return $animals;
    }

    public function getUserAnimalRequests($id)
    {
        $query = "SELECT * FROM (animal INNER JOIN adoptionrequest ON animal.animalID = adoptionrequest.animalID) INNER JOIN user ON user.userID = adoptionrequest.userID WHERE approved IS NOT NULL AND adoptionrequest.userID='" . $id . "'";
        $animals = array();
        try {
            $rows = $this->pdo->query($query);
            if ($rows && $rows->rowCount() >= 1) {
                $animalsArray = $rows->fetchAll();
                foreach ($animalsArray as $a) {
                    $adoptReq = new AdoptionRequests();
                    $adoptReq->adid = $a['adoptionID'];
                    $adoptReq->uid = $a['userID'];
                    $adoptReq->uname = $a['username'];
                    $adoptReq->aid = $a['animalID'];
                    $adoptReq->aname = $a['name'];
                    $adoptReq->isApproved = $a['approved'];
                    $adoptReq->birthdate = $a['dateofbirth'];
                    $adoptReq->description = $a['description'];
                    $adoptReq->picture = $a['photo'];
                    $adoptReq->isAvailble = $a['available'];
                    array_push($animals, $adoptReq);
                }
            }
        } catch (PDOException $ex) {
            array_push($this->errors, $ex->getMessage());
        }
        return $animals;
    }

    public function getAllAnimalsOwners()
    {
        $query = "SELECT * FROM (animal INNER JOIN owns ON animal.animalID = owns.animalID) INNER JOIN user ON user.userID = owns.userID ";
        $animals = array();
        try {
            $rows = $this->pdo->query($query);
            if ($rows && $rows->rowCount() >= 1) {
                $animalsArray = $rows->fetchAll();
                foreach ($animalsArray as $a) {
                    $ownReq = new ownRequest();
                    $ownReq->uid = $a['userID'];
                    $ownReq->uname = $a['username'];
                    $ownReq->aid = $a['animalID'];
                    $ownReq->aname = $a['name'];
                    $ownReq->birthdate = $a['dateofbirth'];
                    $ownReq->description = $a['description'];
                    $ownReq->picture = $a['photo'];
                    array_push($animals, $ownReq);
                }
            }
        } catch (PDOException $ex) {
            array_push($this->errors, $ex->getMessage());
        }
        return $animals;
    }

    public function saveUser($user)
    {
        $query = "INSERT INTO user(username,
            password) VALUES (
            :name, 
            :password 
            )";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':name', $user->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $user->password, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function isUserAvail($username){
        $query = "SELECT username FROM user WHERE username = '" . $username . "'";
        try {
            $row = $this->pdo->query($query);
            if ($row->rowCount() !=0) {
                return false;
            }
            return true;
        } catch (PDOException $ex) {
            array_push($this->errors, $ex->getMessage());
        }
    }
}