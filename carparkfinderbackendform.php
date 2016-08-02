<html>

<head>
    <style>
        .error {color: #FF0000;}
    </style>
</head>

<body>

<?php

$nameErr = $ownerErr = $locationErr = $postcodeErr = $vacanciesErr = "";

$name = $owner = $location = $postcode = $vacancies = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["owner"])) {
        $ownerErr = "Owner name is required";
    } else {
        $owner = test_input($_POST["owner"]);
    }

    if (empty($_POST["location"])) {
        $locationErr = "Location is required";
    } else {
        $location = test_input($_POST["location"]);
    }

    if (empty($_POST["postcode"])) {
        $postcodeErr = "Postcode is required";
    } else {
        $postcode = test_input($_POST["postcode"]);
    }

    if (empty($_POST["vacancies"])) {
        $vacanciesErr = "No. of vacancies is required";
    } else {
        $vacancies = test_input($_POST["vacancies"]);
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<p>

<div>

    <h2>Create new data.</h2>

<?php

echo 'Enter data for the following fields:';

?>

</div>

<div>

    <p><span class="error">* required field.</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Name: <input type="text" name="name">
        <span class="error">* <?php echo $nameErr;?></span>
        <br><br>
        Owner: <input type="text" name="owner">
        <span class="error">* <?php echo $ownerErr;?></span>
        <br><br>
        Location: <input type="text" name="location">
        <span class="error">* <?php echo $locationErr;?></span>
        <br><br>
        Postcode: <input type="text" name="postcode">
        <span class="error">* <?php echo $postcodeErr;?></span>
        <br><br>
        Vacancies: <input type="text" name="vacancies">
        <span class="error">* <?php echo $vacanciesErr;?></span>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php

    $db = new mysqli('localhost', 'root', 'root', 'CARPARKFINDER');

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    echo "<h2>Your Input:</h2>";
    echo "Name: " . $name;
    echo "<br>";
    echo "Owner: " . $owner;
    echo "<br>";
    echo "Location: " . $location;
    echo "<br>";
    echo "Postcode: " . $postcode;
    echo "<br>";
    echo "Vacancies: " . $vacancies;
    echo "<br>";

    if (empty($_POST["name"])) {
        return;
    }

    elseif (empty($_POST["owner"])) {
        return;
    }

    elseif (empty($_POST["location"])) {
        return;
    }

    elseif (empty($_POST["postcode"])) {
        return;
    }

    elseif (empty($_POST["vacancies"])) {
        return;
    }

    else {

        $sql = "INSERT INTO car_parks (Name, Owner, Location, Postcode, Vacancies) VALUES ('" . $name . "', '" . $owner . "', '" . $location . "', '" . $postcode . "', '" . $vacancies . "')";

        if ($db->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }

    }

    ?>

</div>

</p>

</body>

</html>
