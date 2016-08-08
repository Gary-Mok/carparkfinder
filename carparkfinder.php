<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/main.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Car Park Finder
    </title>
</head>

<body>

<?php

include 'bootstrap.php'; //imports functions from functions.php

$location = $postcode = ''; //defines empty strings

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['location']) && strlen($_POST['location']) !== 0) { //following only occurs if location is search criteria

    $location = input($_POST['location']); //if input is not empty, then $location string is set to input
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['postcode']) && strlen($_POST['postcode']) !== 0) { //following only occurs if postcode is search criteria

    $postcode = input($_POST['postcode']); //if input is not empty, then $postcode string is set to input
}

?>

<div class="location">

    <h1>Car Park Finder</h1>

    <p>Search by location.</p>

</div>

<div class="location">

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <br>
        <label for="location">Location:</label> <input type="text" name="location" id="location"> <!--location input-->
        <br><br>
        <input type="submit" name="submit" value="Submit"> <!--location submit-->
    </form>

    <?php

    if (isset($_POST['location']) && strlen($_POST['location']) !== 0) { //following only occurs if location is search criteria and if the input is not empty

        $sql = "SELECT * FROM car_parks WHERE location LIKE '%" . $_POST['location'] . "%'";

        if (!$result = $db->query($sql)) {
            die('There was an error running the query [' . $db->error . ']'); //error message if query fails
        }

        echo '<table><tr><th>Name</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr><td>' . $row['name'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td></tr>';
                //results are displayed in a table
        }

        echo '</table>';
    }

    ?>

</div>

<div class="postcode">

    <p>Search by postcode.</p>

</div>

<div class="postcode">

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <br>
        <label for="postcode">Postcode:</label> <input type="text" name="postcode" id="postcode"> <!--postcode input-->
        <br><br>
        <input type="submit" name="submit" value="Submit"> <!--postcode submit-->
    </form>

    <?php

    if (isset($_POST['postcode']) && strlen($_POST['postcode']) !== 0) { //following only occurs if postcode is search criteria and if the input is not empty

        $space = strpos($_POST['postcode'], ' ');
        $partialcode = substr($_POST['postcode'], 0, $space); //takes only the first half of postcode for query

        $sql = "SELECT * FROM car_parks WHERE postcode LIKE '" . $partialcode . "%'";

        if (!$result = $db->query($sql)) {
            die('There was an error running the query [' . $db->error . ']'); //error message if query fails
        }

        echo '<table><tr><th>Name</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr><td>' . $row['name'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td></tr>';
                //results are displayed in a table
        }

        echo '</table>';
    }

    ?>

</div>
</body>
</html>