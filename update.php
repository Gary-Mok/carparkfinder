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

</body>

</html>