<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Create
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

</body>

</html>