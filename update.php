<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Car Park Finder - Update
    </title>
</head>

<body>

<?php

include 'bootstrap.php';

if (!isset($_SESSION['username'])) {
    header("Location: search.php");
    exit();
}

if ($_SESSION['type'] == "visitor" || $_SESSION['type'] == "owner") {
    echo 'You do not have the administrative right to view this page. Please return to the <a href="search.php">main page</a>.';
    return '';
}

$elements = array(
    'id' => array(
        'description' => 'ID No.',
        'isRequired' => false,
        'type' => 'text',
    ),
    'name' => array(
        'description' => 'Car Park Name',
        'isRequired' => false,
        'type' => 'text',
    ),
    'owner' => array(
        'description' => 'Owner Name',
        'isRequired' => false,
        'type' => 'text',
    ),
    'location' => array(
        'description' => 'Location',
        'isRequired' => false,
        'type' => 'text',
    ),
    'postcode' => array(
        'description' => 'Postcode',
        'isRequired' => false,
        'type' => 'text',
    ),
    'vacancies' => array(
        'description' => 'Vacancies',
        'isRequired' => false,
        'type' => 'text',
    ),
    'submit' => array(
        'description' => 'Submit',
        'isRequired' => false,
        'type' => 'submit',
        'label' => false,
        'isSearchable' => false,
    ),
);

?>

<div>

    <h1>Car Park Finder</h1>

</div>

    <?php include 'navigation.php' ?>

<div>

    <h2>Update records</h2>

    <p>Choose/search for a record to update:</p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <?php echo generateElements($elements) ?>
    </form>

</div>

<?php if(!isset($_POST['submit'])) : ?>

    <div>
        <?php

        $sql = 'SELECT * FROM car_parks';
        $query = $db->prepare($sql);
        $update = $query->execute();

        if ($update === false) {
            die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
        }

        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

            <?php

            echo '<table><tr><th>ID</th><th>Name</th><th>Owner</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr class="tableContents"><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['owner'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td><td><input type="radio" name="check" value="' . $row['id'] . '"></td></tr>';
            }

            echo '</table><br>';

            ?>

            <h3>Update fields:</h3>

            <label for="name">Car Park Name:</label> <input type="text" name="name" id="name"> <!--name input-->
            <br><br>
            <label for="owner">Owner Name:</label> <input type="text" name="owner" id="owner"> <!--owner input-->
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

        $sqlUpdate = 'UPDATE car_parks SET ' . $query . 'WHERE id= :id';
        $queryUpdate = $db->prepare($sqlUpdate);
        $update = $queryUpdate->execute(['id' => $_POST['check']]);

        if ($update === false) {
            echo 'Error: ' . $sqlUpdate . '<br>';
            var_dump($db->errorInfo()); //error message if request fails
            return;
        }

        ?>
    </div>

    <?php

    header("Location: update.php");

    ?>

<?php endif; ?>

<?php if ('POST' === $_SERVER['REQUEST_METHOD']) : ?>

    <div>

        <?php

        $sql = getCarparkSearchQuery($elements, $_REQUEST);
        $query = $db->prepare($sql);
        $check = $query->execute();

        if ($check === false) {
            die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
        }

        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

            <?php

            echo '<table><tr><th>ID</th><th>Name</th><th>Owner</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr class="tableContents"><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['owner'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td><td><input type="radio" name="check" value="' . $row['id'] . '"></td></tr>';
            }

            echo '</table><br>';

            ?>

            <p>Update fields:</p>

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

        $sqlUpdate = 'UPDATE car_parks SET ' . $query . 'WHERE id= :id';
        $queryUpdate = $db->prepare($sqlUpdate);
        $update = $queryUpdate->execute(['id' => $_POST['check']]);

        if ($update === false) {
            echo 'Error: ' . $sqlUpdate . '<br>';
            var_dump($db->errorInfo()); //error message if request fails
            return;
        }

        ?>

    </div>

    <?php

    header("Location: update.php");

    ?>

<?php endif; ?>

</body>

</html>