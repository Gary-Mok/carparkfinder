<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css'/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Request to Add a Car Park</title>
</head>

<body>

<?php

include 'bootstrap.php';

if (!isset($_SESSION['username'])) {
    header("Location: search.php");
    exit();
}

if ($_SESSION['type'] !== "owner") {
    header("Location: search.php");
    exit();
}

$emptyCheck = $name = $owner = $location = $postcode = $vacancies = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateRequest'])) {

    if (strlen($_POST['name']) !== 0) {
        $name = input($_POST['name']);
        $emptyCheck = 'Not empty!';
    }

    if (strlen($_POST['owner']) !== 0) {
        $owner = input($_POST['owner']);
        $emptyCheck = 'Not empty!';
    }

    if (strlen($_POST['location']) !== 0) {
        $location = input($_POST['location']);
        $emptyCheck = 'Not empty!';
    }

    if (strlen($_POST['postcode']) !== 0) {
        $postcode = input($_POST['postcode']);
        $emptyCheck = 'Not empty!';
    }

    if (strlen($_POST['vacancies']) !== 0) {
        $vacancies = input($_POST['vacancies']);
        $emptyCheck = 'Not empty!';
    }
}

?>

<div>

    <h1>Edit Requests</h1>

</div>

<div>

    <h2>Wish to amend details about your car parks?</h2>

    <p>Enter your e-mail address and details about your car park:</p>

</div>

<div>

    <?php

    $sql = 'SELECT * FROM car_parks WHERE member_id = :id';
    $query = $db->prepare($sql);
    $update = $query->execute(['id' => $_SESSION['id']]);

    if ($update === false) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

        <?php

        echo '<table><tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Location</th>
                        <th>Postcode</th>
                        <th>Vacancies</th>
                     </tr>';

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr class="tableContents">
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['owner'] . '</td>
                    <td>' . $row['location'] . '</td>
                    <td>' . $row['postcode'] . '</td>
                    <td>' . $row['vacancies'] . '</td>
                    <td><input type="radio" name="check" value="' . $row['id'] . '"></td>
                  </tr>';
        }

        echo '</table><br>';

        ?>

        <h3>Update fields:</h3>

        <label for="name">Car Park Name:</label> <input type="text" name="name" id="name">
        <br><br>
        <label for="owner">Owner Name:</label> <input type="text" name="owner" id="owner">
        <br><br>
        <label for="location">Location:</label> <input type="text" name="location" id="location">
        <br><br>
        <label for="postcode">Postcode:</label> <input type="text" name="postcode" id="postcode">
        <br><br>
        <label for="vacancies">Vacancies:</label> <input type="text" name="vacancies" id="vacancies">
        <br><br>
        <input type="submit" name="updateRequest" value="Submit">
    </form>

    <p><a href="requests.php">Back</a></p>

    <?php

    if(!isset($_POST['updateRequest'])) {
        return '';
    }

    if (!isset($_POST['check'])) {
        return '';
    }
    
    if ($emptyCheck == '') {
        return '';
    }

    $sql = "INSERT INTO holding (member_id, holding_type_id, name, owner, location, postcode, vacancies, update_id)
            VALUES (:member_id, 2, :name, :owner, :location, :postcode, :vacancies, :update_id)";
    $query = $db->prepare($sql);
    $result = $query->execute(['member_id' => $_SESSION['id'], 'name' => $name, 'owner' => $owner, 'location' => $location, 'postcode' => $postcode, 'vacancies' => $vacancies, 'update_id' => $_POST['check']]);

    if ($result === true) {
        echo 'Request successfully submitted!';
    } else {
        $db->errorInfo();
    }

    ?>

</div>

</body>

</html>