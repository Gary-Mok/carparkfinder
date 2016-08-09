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

?>

<div>
    <h1>Delete records</h1>

    <p>Choose record(s) to delete:</p>
</div>

<div>
    <?php

    $all = array();

    $sql = 'SELECT * FROM car_parks';

    if (!$result = $db->query($sql)) {
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

    echo '</table><br>';

    echo '<input type="submit" name="delete" id="delete" value="Delete">';

    echo '</form>';

    if(!isset($_POST['delete'])) {
        return '';
    }

    if (empty($_POST['list']) && !isset($_POST['all'])) {
        return '';
    }

    if (isset($_POST['all'])) {
        $sqlDelete = 'DELETE FROM car_parks WHERE id IN ('. $allString . ')';

        if ($db->query($sqlDelete) === false) {
            echo 'Error: ' . $sql . '<br>' . $db->error; //error message if request fails
            return;
        }
    }

    elseif ('POST' === $_SERVER['REQUEST_METHOD']) {
        $listString = implode(', ', $_POST['list']);
        $sqlDelete = 'DELETE FROM car_parks WHERE id IN ('. $listString . ')';

        if ($db->query($sqlDelete) === false) {
            echo 'Error: ' . $sql . '<br>' . $db->error; //error message if request fails
            return;
        }
    }
    ?>
</div>

<script type="text/javascript">

    document.getElementById('delete').click();

</script>

</body>

</html>