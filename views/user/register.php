<?php
/**
 * Created by PhpStorm.
 * User: StBoz
 * Date: 28/3/2016
 * Time: 10:58 μμ
 */


session_start();


if (isset($_POST['submitted'])){
    //create a database connection

    require_once("connectdb.php");

    //echo mysql_ping() ? 'true' : 'false';

    //get and sanitise the inputs, we don't need to do this with the password as we hash it anyway
    $safe_username = $db->quote($_POST['username']);
    $hashed_password = md5($_POST['password']);

    //insert the entry into the database
    $query = "insert into user values ('$safe_username', FALSE, '$hashed_password')";

    $db->exec($query);

    //get the ID
    $id = $db->lastInsertId();

    //Output success or the errors
    echo "Congratulations! You are now registered. Your ID is: $id";
}
?>



<html>
<body>
<form action = "register.php" method = "post">

    <p>User Name: <input type="text" name="username" size="15" maxlength="20" /></p>
    <p>Password: <input type="password" name="password" size="15" maxlength="20" /></p>
    <p><input type="submit" name="submit" value="Submit" /></p>
    <input type="hidden" name="submitted" value="TRUE" />
</form>
</body>
</html>