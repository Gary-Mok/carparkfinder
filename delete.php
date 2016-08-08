<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Delete
    </title>
</head>

<body>

<?php

include 'bootstrap.php';

$elements = array(
    'id' => array(
        'description' => 'ID',
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
        'description' => 'Submit',
        'isRequired' => false,
        'type' => 'submit',
        'label' => false,
        'isSearchable' => false,
    ),
);
?>

<div class="filter">
    <h1>Delete records</h1>
    <h2>Search</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <?php echo generateElements($elements) ?>
    </form>
</div>


<?php if ('POST' === $_SERVER['REQUEST_METHOD']) : ?>
    <div class="result">
        <h1>Result</h1>
        <?php

        $all = array();

        if (!$result = $db->query($query = getCarparkSearchQuery($elements, $_REQUEST, $db))) {
            die('There was an error running the query [' . $db->error . ']'); //error message if query fails
        }

        echo '<form method="post">';

        echo '<table><tr><th>ID</th><th>Name</th><th>Owner</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

        while ($row = $result->fetch_array()) {
            echo '<tr><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['owner'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td><td><input type="checkbox" name="list[]" value="' . $row['id'] . '"></td></tr>';
            array_push($all,$row['id']);
        }

        $allString = implode(', ', $all);

        echo '<tr><td colspan="6">Master checkbox</td><td><input type="checkbox" name="all" value=' . $allString . '></td></tr>';

        echo '</table>';

        echo '<input type="submit" name="delete" value="Delete">';

        echo '</form>';

        if(!isset($_POST['delete'])) {
            return '';
        }

        if (empty($_POST['list']) && !isset($_POST['all'])) {
            return '';
        }

        if (isset($_POST['all'])) {
            $sqlDelete = 'DELETE FROM car_parks WHERE id IN ('. $allString . ')';

            if ($db->query($sqlDelete) === true) {
                echo 'Record deleted successfully'; //confirmation message if request passes
            } else {
                echo 'Error: ' . $sql . '<br>' . $db->error; //error message if request fails
            }
        }

        elseif ('POST' === $_SERVER['REQUEST_METHOD']) {
            $listString = implode(', ', $_POST['list']);
            $sqlDelete = 'DELETE FROM car_parks WHERE id IN ('. $listString . ')';

            if ($db->query($sqlDelete) === true) {
                echo 'Record deleted successfully'; //confirmation message if request passes
            } else {
                echo 'Error: ' . $sql . '<br>' . $db->error; //error message if request fails
            }
        }
        ?>
    </div>
<?php endif; ?>

</body>

</html>