<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css'/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Request to Add a Car Park</title>
</head>

<body>

<?php

include 'bootstrap.php';

if (!isset($_SESSION['username'])) {
    header("Location: search.php");
    exit();
}

if ($_SESSION['type'] !== "owner") {
    header("Location: search.php");
    exit();
}

$emailErr = $nameErr = $ownerErr = $paymentErr = '';

$email = $name = $owner = $location = $postcode = $vacancies = $payment = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createRequest'])) {

    if (strlen($_POST['email']) == 0 || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
        $emailErr = 'Valid e-mail is required';
    } else {
        $email = input($_POST['email']);
    }

    if (strlen($_POST['name']) == 0) {
        $nameErr = 'Name is required';
    } else {
        $name = input($_POST['name']);
    }

    if (strlen($_POST['owner']) == 0) {
        $ownerErr = 'Owner name is required';
    } else {
        $owner = input($_POST['owner']);
    }

    if (strlen($_POST['location']) !== 0) {
        $location = input($_POST['location']);
    }

    if (strlen($_POST['postcode']) !== 0) {
        $postcode = input($_POST['postcode']);
    }

    if (strlen($_POST['vacancies']) !== 0) {
        $vacancies = input($_POST['vacancies']);
    }

    if (!isset($_POST['payment'])) {
        $paymentErr = 'Payment type is required';
    } else {
        $payment = input($_POST['payment']);
    }
}

?>

<div>

    <h1>Add Requests</h1>

</div>

<div>

    <h2>You have a car park you wish to add to our database?</h2>

    <p>Enter your e-mail address and details about your car park:</p>

</div>

<div>

    <p><span>* required field.</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <label for="email">E-mail:</label> <input type="text" name="email" id="email">
        <span>* <?php echo $emailErr;?></span>
        <br><br>
        <label for="name">Car Park Name:</label> <input type="text" name="name" id="name">
        <span>* <?php echo $nameErr;?></span>
        <br><br>
        <label for="owner">Owner Name:</label> <input type="text" name="owner" id="owner">
        <span>* <?php echo $ownerErr;?></span>
        <br><br>
        <label for="location">Location:</label> <input type="text" name="location" id="location">
        <br><br>
        <label for="postcode">Postcode:</label> <input type="text" name="postcode" id="postcode">
        <br><br>
        <label for="vacancies">Vacancies:</label> <input type="text" name="vacancies" id="vacancies">
        <br><br>
        <label for="payment">Payment type:</label>
        <span>* <?php echo $paymentErr;?></span><br/>
        <?php

        $ids = array(2,3,4,5,6);
        $inQuery = implode(',', array_fill(0, count($ids), '?'));
        $sql = 'SELECT * FROM transaction_type WHERE id IN(' . $inQuery . ')';
        $query = $db->prepare($sql);
        foreach ($ids as $k => $id) {
            $query->bindValue(($k+1), $id);
        }
        $check = $query->execute();

        if (false === $check) {
            die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
        }

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo $row['description'] . ' (' . abs($row['credit']) . ' credits) <input type="radio" name="payment" id="payment" value="' . $row['id'] . '"><br/>';
        }

        ?>
        <br/>
        <input type="submit" name="createRequest" value="Submit">
    </form>

    <p><a href="requests.php">Back</a></p>

    <?php

    if (!isset($_POST['createRequest'])) {
        return '';
    }

    if (strlen($_POST['email']) == 0 || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
        return '';
    }

    if (strlen($_POST['name']) == 0) {
        return '';
    }

    if(strlen($_POST['owner']) == 0) {
        return '';
    }

    if (!isset($_POST['payment'])) {
        return '';
    }

    $sql = 'SELECT SUM(credit) FROM transactions WHERE member_id = :id';
    $query = $db->prepare($sql);
    $check = $query->execute(['id' => $_SESSION['id']]);

    if (false === $check) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    $creditAmount = $query->fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT credit FROM transaction_type WHERE id = :type_id';
    $query = $db->prepare($sql);
    $check = $query->execute(['type_id' => $payment]);

    if (false === $check) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    $paymentAmount = $query->fetch(PDO::FETCH_ASSOC);

    if (abs($paymentAmount['credit']) > $creditAmount['SUM(credit)']) {
        echo 'Insufficient credit! <a href="addcredit.php">Please add more credit</a>.';
        return '';
    }

    $sql = "INSERT INTO holding (member_id, holding_type_id, name, owner, location, postcode, vacancies, credit) VALUES (:member_id, 1, :name, :owner, :location, :postcode, :vacancies, :credit)";
    $query = $db->prepare($sql);
    $result = $query->execute(['member_id' => $_SESSION['id'], 'name' => $name, 'owner' => $owner, 'location' => $location, 'postcode' => $postcode, 'vacancies' => $vacancies, 'credit' => $paymentAmount['credit']]);

    $msg = "Dear Sir or Madam,\nThank you for considering our services. This is the car park you registered:\nCar Park:" . $name . "\nOwner:" . $owner . "\nLocation:" . $location . "\nPostcode:" . $postcode . "\nVacancies:" . $vacancies . "\nHere are the following charges:\n. Monthly charge\n. Annual charge\n. Special package\n Select your preferred payment method.\nYours faithfully,\nCar Park Finder";

    ini_set('sendmail_from', 'garyjmok@aol.com');

    mail($email,"Add Request for Car Park Finder",$msg);

    if ($result === true) {
        echo 'Request successfully submitted, please check your e-mail!';
    } else {
        $db->errorInfo();
    }

    ?>

</div>

</body>

</html>