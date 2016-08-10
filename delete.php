<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
    <script src="script.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Car Park Finder - Delete
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
        'description' => 'Search',
        'isRequired' => false,
        'type' => 'submit',
        'label' => false,
        'isSearchable' => false,
    ),
);

?>

<div>

    <h1>Car Park Finder</h1>

    <h2>Delete records</h2>

    <?php include 'navigation.php' ?>

    <p>Choose/search for record(s) to delete:</p>

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

        echo '<form method="post" id="delete">';

        echo '<strong>Select all</strong> <input type="checkbox" id="ckbCheckAll" name="all" value="">';

        echo '<table><tr><th>ID</th><th>Name</th><th>Owner</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

        while ($row = $result->fetch_array()) {
            echo '<tr class="tableContents"><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['owner'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td><td><input type="checkbox" class="checkBoxClass" id="Checkbox' . $row['id'] . '" name="list[]" value="' . $row['id'] . '"></td></tr>';
        }

        echo '</table><br>';

        echo '<input type="button" name="delete" id="deleteButton" value="Delete">';

        echo '</form>';

        if (empty($_POST['list'])) {
            return '';
        }

        $listString = implode(', ', $_POST['list']);
        $sqlDelete = 'DELETE FROM car_parks WHERE id IN ('. $listString . ')';

        if ($db->query($sqlDelete) === false) {
            echo 'Error: ' . $sql . '<br>' . $db->error; //error message if request fails
            return;
        }

        ?>

    </div>

<?php endif; ?>

<?php if(isset($_POST['submit'])) : ?>

    <div>
        <?php

        if (!$result = $db->query($query = getCarparkSearchQuery($elements, $_REQUEST, $db))) {
            die('There was an error running the query [' . $db->error . ']'); //error message if query fails
        }

        echo '<form method="post" id="delete">';

        echo '<strong>Select all</strong> <input type="checkbox" id="ckbCheckAll" name="all" value="">';

        echo '<table><tr><th>ID</th><th>Name</th><th>Owner</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

        while ($row = $result->fetch_array()) {
            echo '<tr class="tableContents"><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['owner'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td><td><input type="checkbox" class="checkBoxClass" id="Checkbox' . $row['id'] . '" name="list[]" value="' . $row['id'] . '"></td></tr>';
        }

        echo '</table><br>';

        echo '<input type="button" name="delete" id="deleteButton" value="Delete">';

        echo '</form>';

        if (empty($_POST['list'])) {
            return '';
        }

        $listString = implode(', ', $_POST['list']);
        $sqlDelete = 'DELETE FROM car_parks WHERE id IN ('. $listString . ')';

        if ($db->query($sqlDelete) === false) {
            echo 'Error: ' . $sql . '<br>' . $db->error; //error message if request fails
            return;
        }

        ?>
    </div>

<?php endif; ?>

</body>

</html>