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

    <p>Your current credit is:</p>

    <p>Add credit</p>

</div>

<div>

    <?php

    $id = $_SESSION['id'];

    $sql = 'SELECT transactions.create_at, transaction_type.description, transactions.credit FROM transactions INNER JOIN transaction_type ON transactions.transaction_type_id=transaction_type.id WHERE member_id = :id';
    $query = $db->prepare($sql);
    $credit = $query->execute(['id' => $id]);

    if ($credit === false) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    $dateEntries = array();

    $descriptionEntries = array();

    $creditEntries = array();

    while ($Columns = $query->fetch(PDO::FETCH_ASSOC)) {
        array_push($dateEntries, $Columns['create_at']);
        array_push($descriptionEntries, $Columns['description']);
        array_push($creditEntries, $Columns['credit']);
    }

    $runningTotal = 0;

    echo '<table><tr><th>Debit</th><th>Credit</th><th>Running Total</th></tr>';

    foreach($creditEntries as $entry) {
        $row = array();
        if($entry < 0) {
            $row['debit'] = abs($entry);
            $row['credit'] = 0;
        }
        if($entry > 0) {
            $row['debit'] = 0;
            $row['credit'] = abs($entry);
        }
        $runningTotal = $runningTotal - $row['debit'] + $row['credit'];
        $row['runningTotal'] = $runningTotal;
        echo '<tr><td>' . implode('</td><td>', $row) . '</td></tr>';
    }

    echo '</table>';

    ?>

</div>

</body>

</html>
