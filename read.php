<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Read
    </title>
</head>

<body>

<?php

include 'bootstrap.php';

?>

<div class="read">

    <h1>View records</h1>

</div>

<div class="read">

    <?php

    $sql = 'SELECT * FROM car_parks';

    if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']'); //error message if query fails
    }

    echo '<table><tr><th>ID</th><th>Name</th><th>Owner</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['owner'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td></tr>';
        //database displayed in a table
    }
    echo '</table>';

    ?>

</div>

</body>

</html>