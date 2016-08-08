<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Car Park Finder Backend Forms
    </title>
</head>

<body>

<?php

include 'bootstrap.php'; //imports functions from functions.php

$nameErr = $ownerErr = ''; //defines empty strings

$name = $owner = $location = $postcode = $vacancies = ''; //defines empty strings

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    //following only occurs if user is creating a record

    if (strlen($_POST['name']) == 0) {
        $nameErr = 'Name is required';
    } else {
        $name = input($_POST['name']); //if input is empty, display error message, else set $name to input
    }

    if (strlen($_POST['owner']) == 0) {
        $ownerErr = 'Owner name is required';
    } else {
        $owner = input($_POST['owner']); //if input is empty, display error message, else set $owner to input
    }

    if (strlen($_POST['location']) !== 0) {
        $location = input($_POST['location']); //set $location to input
    }

    if (strlen($_POST['postcode']) !== 0) {
        $postcode = input($_POST['postcode']); //set $postcode to input
    }

    if (strlen($_POST['vacancies']) !== 0) {
        $vacancies = input($_POST['vacancies']); //set $vacancies to input
    }
}

?>

<div class="create">

    <h1>Create new data.</h1>

    <p>Enter data for the following fields:</p>

</div>

<div class="create">

    <p><span>* required field.</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <label for="name">Name:</label> <input type="text" name="name" id="name"> <!--name input-->
        <span>* <?php echo $nameErr;?></span> <!--display error if empty-->
        <br><br>
        <label for="owner">Owner:</label> <input type="text" name="owner" id="owner"> <!--owner input-->
        <span>* <?php echo $ownerErr;?></span> <!--display error if empty-->
        <br><br>
        <label for="location">Location:</label> <input type="text" name="location" id="location"> <!--location input-->
        <br><br>
        <label for="postcode">Postcode:</label> <input type="text" name="postcode" id="postcode"> <!--postcode input-->
        <br><br>
        <label for="vacancies">Vacancies:</label> <input type="text" name="vacancies" id="vacancies"> <!--vacancies input-->
        <br><br>
        <input type="submit" name="create" value="Submit"> <!--create submit-->
    </form>

    <?php

    if (isset($_POST['create']) and strlen($_POST['name']) !== 0 and strlen($_POST['owner']) !== 0) { //following only occurs if user is creating a record

        $sql = "INSERT INTO car_parks (name, owner, location, postcode, vacancies) VALUES ('" . $name . "', '" . $owner . "', '" . $location . "', '" . $postcode . "', '" . $vacancies . "')";

        if ($db->query($sql) === true) {
            echo 'New record created successfully'; //confirmation message if request passes
        } else {
            echo 'Error: ' . $sql . '<br>' . $db->error; //error message if request fails
        }
    }

    ?>

</div>

<div class="read">

    <h1>View database.</h1>

    <p>Click to view current database:</p>

</div>

<div class="read">

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <input type="submit" name="read" value="View database"> <!--read submit-->
    </form>

    <?php

    if (isset($_POST['read'])) { //following only occurs if user is reading records

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
    }

    ?>

</div>

<?php

$idErr = ''; //define empty string

$id = ''; //define empty string

if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['update'])) {
    //following only occurs if user is updating a record
    if (strlen($_POST['id']) == 0) {
        $idErr = 'Car park ID number is required';
    } else {
        $id = input($_POST['id']); //if input is empty, display error message, else set $id to input
    }
}

?>

<div class="update">

    <h1>Update database.</h1>

    <p>Update data in database:</p>

</div>

<div class="update">

    <p><span>* required field.</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <label for="id">ID:</label> <input type="text" name="id" id="id"> <!--id input-->
        <span>* <?php echo $idErr;?></span> <!--display error if empty-->
        <br><br>
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
        <input type="submit" name="update" value="Update"> <!--update submit-->
    </form>

    <?php

    $keysList = array('id'); //define list of columns to update as array

    $valuesList = array($id); //define list of fields to update as array

    if (isset($_POST['update']) && strlen($_POST['id']) !== 0) { //following only occurs if user is updating a record and if id input is not empty

        foreach ($_POST as $key => $value) {
            if ($key != 'update' && $key != 'id' and strlen($value) !== 0) { //ignore $_POST['update'] and $_POST['id'], check for empty string

                array_push($keysList, $key);

                array_push($valuesList, $value); //if input is not empty, add the column and field to arrays
            }
        }

        $queryArray = array(); //define empty array

        for ($i = 0; $i <= count($keysList) - 1; ++$i) {
            $queryArray[$i] = $keysList[$i] . "= '" . $valuesList[$i] . "'"; //merge both arrays into one
        }

        $query = implode(', ', $queryArray); //form mysql query code by imploding merged array with commas

        $sql = 'UPDATE car_parks SET ' . $query . ' WHERE id=' . $id . '';

        if ($db->query($sql) === true) {
            echo 'New record created successfully'; //confirmation message if request passes
        } else {
            echo 'Error: ' . $sql . '<br>' . $db->error; //error message if request fails
        }
    }

    ?>

</div>

<?php

$idErr = ''; //define empty string

$id = ''; //define empty string

if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['delete'])) { //following only occurs if user is deleting a record
    if (strlen($_POST['id']) == 0) {
        $idErr = 'Car park ID number is required';
    } else {
        $id = input($_POST['id']); //if input is empty, display error message, else set $id to input
    }
}

?>

<div class="delete">

    <h1>Delete data from database.</h1>

    <p>Input ID of car park you want to delete from database:</p>

    <p>WARNING: Ensure that the record you want to delete is the correct one. Deleted data cannot be recovered.</p>

</div>

<div class="delete">

    <p><span>* required field.</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <label for="id">ID:</label> <input type="text" name="id" id="id"> <!--id input-->
        <span>* <?php echo $idErr;?></span> <!--display error if empty-->
        <br><br>
        <input type="submit" name="delete" value="Delete"> <!--delete submit-->
    </form>

    <?php

    if (isset($_POST['delete']) and strlen($_POST['id']) !== 0) { //following only occurs if user is deleting a record and if id input is not empty

        $sql = 'DELETE FROM car_parks WHERE id=' . $id . '';

        if ($db->query($sql) === true) {
            echo 'Record deleted successfully'; //confirmation message if request passes
        } else {
            echo 'Error: ' . $sql . '<br>' . $db->error; //error message if request fails
        }
    }

    ?>

</div>

</body>

</html>