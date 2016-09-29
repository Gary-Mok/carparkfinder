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

$creditErr = '';

$credit = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    if (strlen($_POST['credit']) == 0) {
        $creditErr = 'Please insert an integer amount of credit to add';
    } else {
        $credit = input($_POST['credit']);
    }

}

?>

<div>
    <h1>Car Park Finder</h1>
</div>

<?php include 'navigation.php' ?>

<div>

    <h2>Add credit</h2>

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

</div>

<div>

    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <label for="credit">Add credit:</label> <input type="text" name="credit" id="credit" />
        <span>* <?php echo $creditErr;?></span><br/>
        <input type="submit" name="submit" value="Submit" />
    </form>

</div>

<?php

if (!isset($_POST['submit'])) { //following only occurs if user is creating a record
    return '';
}

if (strlen($_POST['credit']) == 0) {
    return '';
}

if(isInteger($_POST['credit']) === false) {
    return '';
}

$sql = 'INSERT INTO transactions (member_id, transaction_type_id, credit, create_at) VALUES ( :id , 7 , :credit , NOW() )';
$query = $db->prepare($sql);
$check = $query->execute(['id' => $_SESSION['id'], 'credit' => $_POST['credit']]);

if (false === $check) {
    die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
} else {
    echo 'Successfully added credit.';
}

?>

</body>

</html>