<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Read
    </title>
</head>

<body>

<?php

include 'bootstrap.php';

$elements = array(
    'id' => array(
        'description' => 'ID No.',
        'isRequired' => false,
        'type' => 'text',
    ),
    'name' => array(
        'description' => 'Carpark Name',
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

    <h1>View records</h1>

    <p><a href="create.php">Create</a> | <a href="update.php">Update</a> | <a href="delete.php">Delete</a></p>

    <p>View/search the database:</p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <?php echo generateElements($elements) ?>
    </form>

</div>

<?php if(!isset($_POST['submit'])) : ?>

<div>

    <?php

    $sql = 'SELECT * FROM car_parks';

    if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']'); //error message if query fails
    }

    echo '<table><tr><th>ID</th><th>Name</th><th>Owner</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr class="tableContents"><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['owner'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td></tr>';
        //database displayed in a table
    }
    echo '</table>';

    ?>

</div>

<?php endif; ?>

<?php if ('POST' === $_SERVER['REQUEST_METHOD']) : ?>
    
    <div>
        <?php
        if (!$result = $db->query($query = getCarparkSearchQuery($elements, $_REQUEST, $db))) {
            die('There was an error running the query [' . $db->error . ']'); //error message if query fails
        }

        echo '<table><tr><th>ID</th><th>Name</th><th>Owner</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

        while ($row = $result->fetch_array()) {
            echo '<tr class="tableContents"><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['owner'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td></tr>';
        }

        echo '</table><br>';
        ?>
    </div>
    
<?php endif; ?>

</body>

</html>