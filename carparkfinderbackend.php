<?php

$db = new mysqli('localhost', 'root', 'root', 'CARPARKFINDER');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

$sql = "INSERT INTO car_parks (Name, Owner, Location, Postcode, Vacancies)
VALUES ('" . $_POST["name"] . "', '" . $_POST["owner"] . "', '" . $_POST["location"] . "', '" . $_POST["postcode"] . "', '" . $_POST["vacancies"] . "')";

if ($db->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
}

?>
