<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Credit - Admin
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

?>

<div>

    <h1>Car Park Finder</h1>

</div>

<?php include 'navigation.php' ?>

<div>

    <h2>View transactions:</h2>

</div>

<div>

    <?php

    $id = $_SESSION['id'];

    $sql = 'SELECT * FROM transactions WHERE member_id LIKE :id';
    $query = $db->prepare($sql);
    $trans = $query->execute(['id' => $id]);

    if ($trans === false) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    echo '<table><tr><th>Transaction Type ID</th><th>Credit</th><th>Date</th></tr>';

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr class="tableContents"><td>' . $row['transaction_type_id'] . '</td><td>' . $row['credit'] . '</td><td>' . $row['create_at'] . '</td></tr>';
        //database displayed in a table
    }
    echo '</table>';

    ?>

</div>

</body>

</html>
