<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css'/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Holding Requests
    </title>
</head>

<body>

<?php

include 'bootstrap.php';

if (!isset($_SESSION['username'])) {
    header("Location: search.php");
    exit();
}

if ($_SESSION['type'] !== "admin") {
    echo 'You do not have the administrative right to view this page. Please return to the <a href="search.php">main page</a>.';
    return '';
}

?>

<div>

    <h1>Car Park Finder</h1>

</div>

<?php include 'navigation.php' ?>

<div>

    <h2>All user requests:</h2>

</div>

<div>

    <?php

    $sql = 'SELECT holding.id, members.username, holding_type.type, holding.name, holding.owner, holding.location, holding.postcode, holding.vacancies, holding.credit FROM holding INNER JOIN members ON holding.member_id=members.id INNER JOIN holding_type ON holding.holding_type_id=holding_type.id ORDER BY holding.id ASC';
    $query = $db->prepare($sql);
    $trans = $query->execute();

    if ($trans === false) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    echo '<table><tr><th>ID</th><th>Member</th><th>Request Type</th><th>Name</th><th>Owner</th><th>Location</th><th>Postcode</th><th>Vacancies</th><th>Request Cost</th></tr>';

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr class="tableContents"><td>' . $row['id'] . '</td><td>' . $row['username'] . '</td><td>' . $row['type'] . '</td><td>' . $row['name'] . '</td><td>' . $row['owner'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td><td>' . $row['credit'] . '</td></tr>';
    }
    echo '</table>';

    ?>

</div>

</body>

</html>
