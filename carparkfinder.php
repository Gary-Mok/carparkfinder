<html>

<head>
    <style>
        .error {color: #FF0000;}
    </style>

    <title>
        Car Park Finder
    </title>
</head>

<body>

<?php

$location = $postcode = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["location"])) {
    }
    else {
        $location = location_input($_POST["location"]);
    }
    if (empty($_POST["postcode"])) {
    }
    else {
        $postcode = postcode_input($_POST["postcode"]);
    }
}

function location_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;

}

function postcode_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<div>

    <h1>Car Park Finder</h1>

    <?php

    echo 'Search by location.';

    ?>

</div>

<div>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <br>
        Location: <input type="text" name="location">
        <br><br>
        <input type="submit" name="submit_location" value="Submit">
    </form>

<?php

$db = new mysqli('localhost', 'root', 'root', 'CARPARKFINDER');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

if (empty($_POST["location"])) {
}

else {

    $sql = "SELECT * FROM car_parks WHERE Location LIKE '%" . $_POST["location"] . "%'";

    if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
    }

    while ($row = $result->fetch_assoc()) {
        echo 'Name: ' . $row['Name'] . '<br />';
        echo 'Vacancies: ' . $row['Vacancies'] . '<br />';
        echo 'Location: ' . $row['Location'] . '<br />';
        echo 'Postcode: ' . $row['Postcode'] . '<br /><br />';
    }

}

?>

</div>

<div>

    <?php

    echo 'Search by postcode.';

    ?>

</div>

<div>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <br>
        Postcode: <input type="text" name="postcode">
        <br><br>
        <input type="submit" name="submit_postcode" value="Submit">
    </form>

    <?php

    $db = new mysqli('localhost', 'root', 'root', 'CARPARKFINDER');

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    if (empty($_POST["postcode"])) {
    }

    else {

        $space = strpos($_POST["postcode"]," ");
        $partialcode = substr($_POST["postcode"], 0, $space);

        $sql = "SELECT * FROM car_parks WHERE Postcode LIKE '" . $partialcode . "%'";

        if (!$result = $db->query($sql)) {
            die('There was an error running the query [' . $db->error . ']');
        }

        while ($row = $result->fetch_assoc()) {
            echo 'Name: ' . $row['Name'] . '<br />';
            echo 'Vacancies: ' . $row['Vacancies'] . '<br />';
            echo 'Location: ' . $row['Location'] . '<br />';
            echo 'Postcode: ' . $row['Postcode'] . '<br /><br />';
        }

    }

    ?>

</div>

</body>

</html>