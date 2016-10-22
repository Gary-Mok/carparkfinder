<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Car Park Finder - Create
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

$nameErr = $ownerErr = $memberErr = ''; //defines empty strings

$name = $owner = $location = $postcode = $vacancies = $member_id = ''; //defines empty strings

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

    if (strlen($_POST['member']) == 0) {
        $memberErr = 'Please assign a designated member';
    } else {
        $member_id = input($_POST['member']); //if input is empty, display error message, else set $member_id to input
    }
}

?>

<div class="create">

    <h1>Car Park Finder</h1>

</div>

<?php include 'navigation.php' ?>

<div>

    <h2>Create records</h2>

    <p>Enter data for the following fields:</p>

</div>

<div class="create">

    <p><span>* required field.</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <label for="name">Car Park Name:</label> <input type="text" name="name" id="name"> <!--name input-->
        <span>* <?php echo $nameErr;?></span> <!--display error if empty-->
        <br><br>
        <label for="owner">Owner Name:</label> <input type="text" name="owner" id="owner"> <!--owner input-->
        <span>* <?php echo $ownerErr;?></span> <!--display error if empty-->
        <br><br>
        <label for="location">Location:</label> <input type="text" name="location" id="location"> <!--location input-->
        <br><br>
        <label for="postcode">Postcode:</label> <input type="text" name="postcode" id="postcode"> <!--postcode input-->
        <br><br>
        <label for="vacancies">Vacancies:</label> <input type="text" name="vacancies" id="vacancies"> <!--vacancies input-->
        <br><br>
        <label for="member">Member:</label> <select name="member" id="member">
            <option value=""></option>
            <?php

            $sql = 'SELECT members.id, members.username
                    FROM members
                    WHERE members.type="owner"
                    ORDER BY members.id ASC';
            $query = $db->prepare($sql);
            $check = $query->execute();

            if ($check === false) {
                die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
            }

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
            }

            ?>
        </select> <!--member input-->
        <span>* <?php echo $memberErr;?></span> <!--display error if empty-->
        <br><br>
        <input type="submit" name="create" value="Submit"> <!--create submit-->
    </form>

    <?php

    if (!isset($_POST['create'])) { //following only occurs if user is creating a record
        return '';
    }

    if (strlen($_POST['name']) == 0) {
        return '';
    }

    if(strlen($_POST['owner']) == 0) {
        return '';
    }

    if(strlen($_POST['member']) == 0) {
        return '';
    }

    $sql = "INSERT INTO car_parks (name, owner, location, postcode, vacancies, member_id)
            VALUES (:name, :owner, :location, :postcode, :vacancies, :member)";
    $query = $db->prepare($sql);
    $result = $query->execute(['name' => $name, 'owner' => $owner, 'location' => $location, 'postcode' => $postcode, 'vacancies' => $vacancies, 'member' => $member_id]);

    $idCreate = '';

    if ($result === true) {
        $idCreate = $db->lastInsertId();
        echo 'New record created successfully'; //confirmation message if request passes
    } else {
        $db->errorInfo(); //error message if request fails
    }

    echo '<p>Result:</p>';

    $sql = 'SELECT car_parks.id, car_parks.name, car_parks.owner, car_parks.location, car_parks.postcode, car_parks.vacancies, members.username
            FROM car_parks
            INNER JOIN members ON car_parks.member_id = members.id
            WHERE car_parks.id= :id';
    $query = $db->prepare($sql);
    $check = $query->execute(['id' => $idCreate]);
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($check === false) {
        $db->errorInfo(); //error message if query fails
    }

    echo '<table><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Location</th>
                    <th>Postcode</th>
                    <th>Vacancies</th>
                    <th>Member</th>
                 </tr>';

    echo '<tr>
            <td>' . $row['id'] . '</td>
            <td>' . $row['name'] . '</td>
            <td>' . $row['owner'] . '</td>
            <td>' . $row['location'] . '</td>
            <td>' . $row['postcode'] . '</td>
            <td>' . $row['vacancies'] . '</td>
            <td>' . $row['username'] . '</td>
          </tr>';
    //database displayed in a table
    echo '</table>';

    ?>

</div>

</body>

</html>