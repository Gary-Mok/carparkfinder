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

    <p>Your current credit is:

    <?php

    $id = $_SESSION['id'];

    $sql = 'SELECT transactions.credit FROM transactions WHERE member_id = :id AND id = (SELECT MAX(id) FROM transactions WHERE member_id = :id)';
    $query = $db->prepare($sql);
    $credit = $query->execute(['id' => $id]);

    if ($credit === false) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    $row = $query->fetch(PDO::FETCH_ASSOC);

    echo $row['credit'];

    ?>

    </p>

    <p>Add credit</p>

</div>

<div>

    <?php

    $id = $_SESSION['id'];

    $sql = 'SELECT transaction_type.description, transactions.credit, transactions.create_at FROM transactions INNER JOIN transaction_type ON transactions.transaction_type_id=transaction_type.id WHERE member_id LIKE :id ORDER BY transactions.create_at ASC';
    $query = $db->prepare($sql);
    $trans = $query->execute(['id' => $id]);

    if ($trans === false) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    echo '<table><tr><th>Transaction</th><th>Credit</th><th>Date</th></tr>';

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr class="tableContents"><td>' . $row['description'] . '</td><td>' . $row['credit'] . '</td><td>' . $row['create_at'] . '</td></tr>';
        //database displayed in a table
    }
    echo '</table>';

    ?>

</div>

</body>

</html>
