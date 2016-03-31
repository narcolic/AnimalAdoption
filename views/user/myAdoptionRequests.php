<?php
/**
 * Created by PhpStorm.
 * User: narcolic
 * Date: 25/3/2016
 * Time: 10:59 μμ
 */
//Users' pending adoption requests
echo "<table>";
echo "<tr>";
echo "<th>Animal_ID</th>";
echo "<th>Name</th>";
echo "<th>Owner</th>";
echo "<th>Date_Of_Birth</th>";
echo "<th>Description</th>";
echo "<th>Photo</th>";
echo "</tr>";

$myadoptquery = "select animalID,name,dateofbirth,description,photo from animal where animalID = (SELECT animalID from adoptionrequest WHERE userID = 'globaluserID' AND approved = NULL ) ";

$rows = $db->query($myadoptquery);
//loop through all the returned records and put them into the table cells
foreach ($rows as $row) {
    echo "<tr><td >" . $row['animalID'] . "</td><td >" . $row['name'] . "</td><td >" . $row['dateofbirth'];
    echo "</td><td >" . $row['description'] . "</td><td ><img src=" . $row['photo'] . " alt='Smiley face' height='50' width='50'></td></tr>\n";
}

echo "</table>";
echo "<br/>";