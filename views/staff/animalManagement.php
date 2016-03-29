<?php
/**
 * Created by PhpStorm.
 * User: makis
 * Date: 28/3/2016
 * Time: 3:16 μμ
 */
if (isset($_POST['submitted'])) {
    // error array to  list all error in the form input
    $errors = array();
    require_once("connectdb.php");

    //get the form data and do some basic validation
    if (!empty ($_POST['aname'])) {
        $aname = $_POST['aname'];
    } else {
        $errors[] = "You must input a valid animal name! <br>";
    }

    if (!empty ($_POST['dateofbirth'])) {
        $dateofbirth = $_POST['dateofbirth'];
    } else {
        $errors[] = "You must input a valid date! <br>";
    }

    if (!empty($_POST['description'])) {
        $description = $_POST['description'];
    } else {
        $errors[] = "Please input an animal description.<br>";
    }

    $file = null;
    //get the file name from form input and move it to images folder
    if ($_FILES["pic"]["error"] > 0) {
        $errors[] = "Error in uploading file <br />";
    } else {
        $type = $_FILES["pic"]["type"];
        //if the type is one of the three image types
        if (($type == "image/jpeg") || ($type == "image/png") || ($type == "image/gif")) {
            //move the file to a sub-directory called images
            move_uploaded_file($_FILES["pic"]["tmp_name"], "images/" . $_FILES["pic"]["name"]);
            $file = "images/" . $_FILES["pic"]["name"];
        } else {
            $errors[] = "Wrong File Type! Only jpeg, png and gid allowed";
        }
    }

    //if there were errors then output the messages
    if (!empty($errors)) {
        echo "<h1> Errors with form submission: </h1><br>";
        echo "<ul>";
        foreach ($errors as $e) {
            echo "<li> $e </li>";
        }
        echo "</ul>";
    } else {

        try {
            // use the form data to create a insert SQL and  add a student record
            $sth = $db->prepare("INSERT INTO animal(animalID, name, dateofbirth, description, photo) VALUES (?,?,?,?,?,?)");
            $sth->execute(array($course, $firstname, $surname, $gender, $year, $file));
            echo " Well Done, you just add one animal record! <br><br>";
        } catch (PDOException $ex) {
            //this catches the exception when it is thrown
            echo "Sorry, a database error occurred. Please try again.<br> ";
            echo "Error details:" . $ex->getMessage();
        }
    }
} ?>


<html>
<body>
<form method="post" action="animalManagement.php" enctype="multipart/form-data">
    Animal Name: <input type="text" name="aname"/><br/><br/>
    Date of Birth: <input type="date" name="dateofbirth"/><br/><br/>
    Description: <input type="text" name="description"><br/><br/>
    Submit Your image (only jpeg, png,gif are allowed):<br/> <br/>
    <input type="file" name="pic"/>
    <input type="hidden" name="submitted" value="true"/>
    <input type="submit" name="submit" value="Submit"/>
    <input type="reset" value="clear"/>
</form>

<h2><a href="register.php"> Or click here to register </a></h2>
</body>
</html>