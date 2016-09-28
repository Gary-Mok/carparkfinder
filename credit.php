<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css'/>
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

if (isset($_SESSION['type']) && $_SESSION['type'] === "visitor") {
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

    $sql = 'SELECT transactions.create_at, transaction_type.description, transactions.credit 
FROM transactions 
INNER JOIN transaction_type ON transactions.transaction_type_id=transaction_type.id 
WHERE member_id = :id';

    $query = $db->prepare($sql);
    $credit = $query->execute(['id' => $id]);

    if (false === $credit) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    $runningTotal = 0;
    $entries = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $runningTotal += $row['credit'];
        $entry = array();
        $entry['transactionDescription'] = $row['description'];
        $entry['debit'] = $row['credit'] < 0 ? abs($row['credit']) : 0;
        $entry['credit'] = $row['credit'] > 0 ? abs($row['credit']) : 0;
        $entry['runningTotal'] = $runningTotal;

        $entries[] = $entry;
    }

    echo '<table><tr><th>Transaction Description</th><th>Debit</th><th>Credit</th><th>Running Total</th></tr>';

    foreach ($entries as $entry) {
        echo '<tr><td>' . implode('</td><td>', $entry) . '</td></tr>';
    }

    echo '</table>';

    ?>
</div>
</body>
</html>
