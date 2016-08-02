<html>

<body>

<p>

<?php

$db = new mysqli('localhost', 'root', 'root', 'CARPARKFINDER');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

$sql = <<<SQL
SELECT * FROM car_parks WHERE Postcode LIKE 'WD%'
SQL;

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}

while($row = $result->fetch_assoc()){
    echo 'Name: ' . $row['Name'] . '<br />';
    echo 'Vacancies: ' . $row['Vacancies'] . '<br />';
    echo 'Location: ' . $row['Location'] . '<br />';
    echo 'Postcode: ' . $row['Postcode'] . '<br />';
}

?>

</p>

</body>

</html>