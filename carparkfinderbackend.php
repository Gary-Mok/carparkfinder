<html>

<head>
    <style>
        .error {color: #FF0000;}
    </style>

    <title>
        Car Park Finder Backend Forms
    </title>
</head>

<body>

<?php

$nameErr = $ownerErr = $locationErr = $postcodeErr = $vacanciesErr = "";

$name = $owner = $location = $postcode = $vacancies = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['create'])) {

        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name = create_input($_POST["name"]);
        }

        if (empty($_POST["owner"])) {
            $ownerErr = "Owner name is required";
        } else {
            $owner = create_input($_POST["owner"]);
        }

        if (empty($_POST["location"])) {
            $locationErr = "Location is required";
        } else {
            $location = create_input($_POST["location"]);
        }

        if (empty($_POST["postcode"])) {
            $postcodeErr = "Postcode is required";
        } else {
            $postcode = create_input($_POST["postcode"]);
        }

        if (empty($_POST["vacancies"])) {
            $vacanciesErr = "No. of vacancies is required";
        } else {
            $vacancies = create_input($_POST["vacancies"]);
        }
    }
}

function create_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<div>

    <h1>Create new data.</h1>

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
        <input type="submit" name="create" value="Submit">
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
    }

    elseif (empty($_POST["owner"])) {
    }

    elseif (empty($_POST["location"])) {
    }

    elseif (empty($_POST["postcode"])) {
    }

    elseif (empty($_POST["vacancies"])) {
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

<div>

    <h1>View database.</h1>

    <?php

    echo 'Click to view current database:';

    ?>

</div>

<div>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="submit" name="read" value="View database">
    </form>

    <?php

    if (isset($_POST['read'])) {

        $sql = "SELECT * FROM car_parks";

        if (!$result = $db->query($sql)) {
            die('There was an error running the query [' . $db->error . ']');
        }

        while ($row = $result->fetch_assoc()) {
            echo 'ID No.: ' . $row['ID'] . '<br />';
            echo 'Name: ' . $row['Name'] . '<br />';
            echo 'Owner: ' . $row['Owner'] . '<br />';
            echo 'Location: ' . $row['Location'] . '<br />';
            echo 'Postcode: ' . $row['Postcode'] . '<br />';
            echo 'Vacancies: ' . $row['Vacancies'] . '<br /><br />';
        }

    }


    ?>

</div>

<?php

$idErr = "";

$id = $updatename = $updateowner = $updatelocation = $updatepostcode = $updatevacancies = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['update'])) {

        if (empty($_POST["id"])) {
            $idErr = "Car park ID number is required";
        } else {
            $id = update_input($_POST["id"]);
        }

        if (empty($_POST["updatename"])) {
        } else {
            $updatename = update_input($_POST["updatename"]);
        }

        if (empty($_POST["updateowner"])) {
        } else {
            $updateowner = update_input($_POST["updateowner"]);
        }

        if (empty($_POST["updatelocation"])) {
        } else {
            $updatelocation = update_input($_POST["updatelocation"]);
        }

        if (empty($_POST["updatepostcode"])) {
        } else {
            $updatepostcode = update_input($_POST["updatepostcode"]);
        }

        if (empty($_POST["updatevacancies"])) {
        } else {
            $updatevacancies = update_input($_POST["updatevacancies"]);
        }
    }
}

function update_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<div>

    <h1>Update database.</h1>

    <?php

    echo 'Update data in database:';

    ?>

</div>

<div>

    <p><span class="error">* required field.</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        ID: <input type="text" name="id">
        <span class="error">* <?php echo $idErr;?></span>
        <br><br>
        Name: <input type="text" name="updatename">
        <br><br>
        Owner: <input type="text" name="updateowner">
        <br><br>
        Location: <input type="text" name="updatelocation">
        <br><br>
        Postcode: <input type="text" name="updatepostcode">
        <br><br>
        Vacancies: <input type="text" name="updatevacancies">
        <br><br>
        <input type="submit" name="update" value="Update">
    </form>

    <?php

    if (empty($_POST["id"])) {
    }

    else {

        if (empty($_POST["updatename"])) {
        }
        else {
            $sql = "UPDATE car_parks SET Name='" . $updatename . "' WHERE ID=" . $id . "";

            if ($db->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }
        }

        if (empty($_POST["updateowner"])) {
        }
        else {
            $sql = "UPDATE car_parks SET Owner='" . $updateowner . "' WHERE ID=" . $id . "";

            if ($db->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }
        }

        if (empty($_POST["updatelocation"])) {
        }
        else {
            $sql = "UPDATE car_parks SET Location='" . $updatelocation . "' WHERE ID=" . $id . "";

            if ($db->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }
        }

        if (empty($_POST["updatepostcode"])) {
        }
        else {
            $sql = "UPDATE car_parks SET Postcode='" . $updatepostcode . "' WHERE ID=" . $id . "";

            if ($db->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }
        }

        if (empty($_POST["updatevacancies"])) {
        }
        else {
            $sql = "UPDATE car_parks SET Vacancies='" . $updatevacancies . "' WHERE ID=" . $id . "";

            if ($db->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }
        }

    }

    ?>

</div>

</body>

</html>
