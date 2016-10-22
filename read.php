<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Car Park Finder - Read
    </title>
</head>

<body>

<?php

include 'bootstrap.php';

if (!isset($_SESSION['username'])) {
    header("Location: search.php");
    exit();
}

if ($_SESSION['type'] == "visitor") {
    echo 'You do not have the administrative right to view this page. Please return to the <a href="search.php">main page</a>.';
    return '';
}

$elements = array(
    'car_parks_period_id' => array(
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
    'member_id' => array(
        'description' => 'Member',
        'isRequired' => false,
        'type' => 'select',
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

    <h2>View records</h2>

    <p>View/search the database:</p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <?php echo generateElements($elements) ?>
    </form>

</div>

<?php if(!isset($_POST['submit'])) : ?>

    <div>

        <?php

        $sql = 'SELECT car_parks.id, car_parks.name, car_parks.owner, car_parks.location, car_parks.postcode, car_parks.vacancies, members.username
                FROM car_parks
                INNER JOIN members ON car_parks.member_id = members.id';
        $query = $db->prepare($sql);
        $read = $query->execute();

        if ($read === false) {
            die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
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

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr class="tableContents">
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['owner'] . '</td>
                    <td>' . $row['location'] . '</td>
                    <td>' . $row['postcode'] . '</td>
                    <td>' . $row['vacancies'] . '</td>
                    <td>' . $row['username'] . '</td>
                  </tr>';
            //database displayed in a table
        }
        echo '</table>';

        ?>

    </div>

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

        echo '<table><tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Location</th>
                        <th>Postcode</th>
                        <th>Vacancies</th>
                        <th>Member</th>
                     </tr>';

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr class="tableContents">
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['owner'] . '</td>
                    <td>' . $row['location'] . '</td>
                    <td>' . $row['postcode'] . '</td>
                    <td>' . $row['vacancies'] . '</td>
                    <td>' . $row['username'] . '</td>
                  </tr>';
        }

        echo '</table>';
        ?>
    </div>

<?php endif; ?>

</body>

</html>