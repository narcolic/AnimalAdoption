<?php

/**
 * Created by PhpStorm.
 * User: makis
 * Date: 29/3/2016
 * Time: 9:08 μμ
 */
class TableRequests
{

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
            echo "<p> database error occurred: <em> $ex->getMessage() </em></p>";
        }
    }

    public function allAdoptReq() {
        $query = "select animalID,name,dateofbirth,description,photo from animal where animalID = (SELECT animalID from adoptionrequest WHERE approved != NULL ) ";
        try {
            $rows = $this->pdo-> query($query);
            if ($rows && $rows->rowCount() ==1) {
                $row=$rows->fetch();
                $animalarray = array($row['animalID'],$row['name'],$row['dateofbirth'],$row['description'],$row['photo']);
                return $animalarray;
            }
            else return null;
        } catch (PDOException $ex) {
            echo "<p> database error occurred: <em> $ex->getMessage() </em></p>";
        }
    }

    public function userPendingAdoptReq($id) {
        $query = "select animalID,name,dateofbirth,description,photo from animal where animalID = (SELECT animalID from adoptionrequest WHERE userID = '$id' AND approved = NULL ) ";
        try {
            $rows = $this->pdo-> query($query);
            if ($rows && $rows->rowCount() ==1) {
                $row=$rows->fetch();
                $animalarray = array($row['animalID'],$row['name'],$row['dateofbirth'],$row['description'],$row['photo']);
                return $animalarray;
            }
            else return null;
        } catch (PDOException $ex) {
            echo "<p> database error occurred: <em> $ex->getMessage() </em></p>";
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
            echo "<p> database error occurred: <em> $ex->getMessage() </em></p>";
        }
    }
    
    
}