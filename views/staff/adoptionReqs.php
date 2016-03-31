<?php
/**
 * Created by PhpStorm.
 * User: narcolic
 * Date: 25/3/2016
 * Time: 10:56 μμ
 */

//table of pending adopt requests
echo "<table>";
echo "<tr>";
echo "<th>Animal_ID</th>";
echo "<th>Name</th>";
echo "<th>Date_Of_Birth</th>";
echo "<th>Description</th>";
echo "<th>Photo</th>";
echo "</tr>";

$pendquery = "select animalID,name,dateofbirth,description,photo from animal where available = TRUE ";

$rows = $db->query($pendquery);
//loop through all the returned records and put them into the table cells
foreach ($rows as $row) {
    echo "<tr><td >" . $row['animalID'] . "</td><td >" . $row['name'] . "</td><td >" . $row['dateofbirth'];
    echo "</td><td >" . $row['description'] . "</td><td ><img src=" . $row['photo'] . " alt='Smiley face' height='50' width='50'></td></tr>\n";
}
echo "</table>";
echo "<br/>";


//table of all adopt requests (approved/denied)
echo "<table>";
echo "<tr>";
echo "<th>Animal_ID</th>";
echo "<th>Name</th>";
echo "<th>Date_Of_Birth</th>";
echo "<th>Description</th>";
echo "<th>Photo</th>";
echo "</tr>";

$allquery = "select animalID,name,dateofbirth,description,photo from animal where animalID = (SELECT animalID from adoptionrequest WHERE approved != NULL ) ";

$rows = $db->query($allquery);
//loop through all the returned records and put them into the table cells
foreach ($rows as $row) {
    echo "<tr><td >" . $row['animalID'] . "</td><td >" . $row['name'] . "</td><td >" . $row['dateofbirth'];
    echo "</td><td >" . $row['description'] . "</td><td ><img src=" . $row['photo'] . " alt='Smiley face' height='50' width='50'></td></tr>\n";
}
echo "</table>";
echo "<br/>";

