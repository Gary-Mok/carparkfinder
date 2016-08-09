<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Update
    </title>
</head>

<body>

<?php

include 'bootstrap.php';

?>

<div class="update">

    <h1>Update records</h1>

    <p>Choose record to update:</p>

</div>

<div>
    <?php

    $sql = 'SELECT * FROM car_parks';

    if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']'); //error message if query fails
    }

    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

        <?php

        echo '<table><tr><th>ID</th><th>Name</th><th>Owner</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

        while ($row = $result->fetch_array()) {
            echo '<tr><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['owner'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td><td><input type="radio" name="check" value="' . $row['id'] . '"></td></tr>';
        }

        echo '</table><br>';

        ?>

        <label for="name">Name:</label> <input type="text" name="name" id="name"> <!--name input-->
        <br><br>
        <label for="owner">Owner:</label> <input type="text" name="owner" id="owner"> <!--owner input-->
        <br><br>
        <label for="location">Location:</label> <input type="text" name="location" id="location"> <!--location input-->
        <br><br>
        <label for="postcode">Postcode:</label> <input type="text" name="postcode" id="postcode"> <!--postcode input-->
        <br><br>
        <label for="vacancies">Vacancies:</label> <input type="text" name="vacancies" id="vacancies"> <!--vacancies input-->
        <br><br>

        <input type="submit" name="update" id="update" value="Update">

    </form>

    <?php

    if(!isset($_POST['update'])) {
        return '';
    }

    if (!isset($_POST['check'])) {
        return '';
    }

    $keysList = array('id'); //define list of columns to update as array

    $valuesList = array($_POST['check']); //define list of fields to update as array

    foreach ($_POST as $key => $value) {
        if ($key != 'update' && $key != 'check' and strlen($value) !== 0) { //ignore $_POST['update'] and $_POST['id'], check for empty string

            array_push($keysList, $key);

            array_push($valuesList, $value); //if input is not empty, add the column and field to arrays
        }
    }

    $queryArray = array(); //define empty array

    for ($i = 0; $i <= count($keysList) - 1; ++$i) {
        $queryArray[$i] = $keysList[$i] . "= '" . $valuesList[$i] . "'"; //merge both arrays into one
    }

    $query = implode(', ', $queryArray); //form mysql query code by imploding merged array with commas

    $sqlUpdate = 'UPDATE car_parks SET ' . $query . ' WHERE id=' . $_POST['check'] . '';

    if ($db->query($sqlUpdate) === false) {
        echo 'Error: ' . $sql . '<br>' . $db->error; //error message if request fails
        return;
    }

    ?>
</div>

<script type="text/javascript">

    document.getElementById('update').click();

</script>

</body>

</html>