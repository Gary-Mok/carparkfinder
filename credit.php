<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css'/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Transactions
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

    <p>Your current credit is:

        <?php

        $sql = 'SELECT SUM(credit) FROM transactions WHERE member_id = :id';
        $query = $db->prepare($sql);
        $check = $query->execute(['id' => $_SESSION['id']]);

        if (false === $check) {
            die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
        }

        $creditAmount = $query->fetch(PDO::FETCH_ASSOC);

        echo $creditAmount['SUM(credit)'];

        ?>

    </p>

    <p><a href="addcredit.php">Add credit</a></p>

</div>

<div>

    <?php

    $sql = 'SELECT transactions.create_at, transaction_type.description, transactions.credit 
FROM transactions 
INNER JOIN transaction_type ON transactions.transaction_type_id=transaction_type.id 
WHERE member_id = :id';

    $query = $db->prepare($sql);
    $credit = $query->execute(['id' => $_SESSION['id']]);

    if (false === $credit) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    $runningTotal = 0;
    $debitTotal = 0;
    $creditTotal = 0;
    $entries = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $runningTotal += $row['credit'];
        $entry = array();
        $entry['transactionDate'] = $row['create_at'];
        $entry['transactionDescription'] = $row['description'];
        $entry['debit'] = $row['credit'] < 0 ? abs($row['credit']) : 0;
        $entry['credit'] = $row['credit'] > 0 ? abs($row['credit']) : 0;
        $entry['runningTotal'] = $runningTotal;
        $debitTotal = $debitTotal + $entry['debit'];
        $creditTotal = $creditTotal + $entry['credit'];

        $entries[] = $entry;
    }

    echo '<table><tr><th>Date</th><th>Transaction Description</th><th>Debit</th><th>Credit</th><th>Running Total</th></tr>';

    foreach ($entries as $entry) {
        echo '<tr><td>' . implode('</td><td>', $entry) . '</td></tr>';
    }

    echo '<tr><td colspan="2">Total</td><td>'. $debitTotal . '</td><td>'. $creditTotal . '</td><td></td></tr></table>';

    ?>
</div>
</body>
</html>
