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

$emailErr = ''; //defines empty strings

$email = ''; //defines empty strings

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createRequest'])) {

    if (strlen($_POST['email']) == 0 || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
        $emailErr = 'Valid e-mail is required';
    } else {
        $email = input($_POST['email']);
    }
}

?>

<div>

    <h1>Add Requests</h1>

</div>

<div>

    <h2>You have a car park you wish to add to our database?</h2>

    <p>Enter your e-mail address to receive payment package details:</p>

</div>

<div>

    <p><span>* required field.</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <label for="email">E-mail:</label> <input type="text" name="email" id="email">
        <span>* <?php echo $emailErr;?></span>
        <br><br>
        <input type="submit" name="createRequest" value="Submit"> <!--create submit-->
    </form>

    <p><a href="requests.php">Back</a></p>

    <?php

    if (!isset($_POST['createRequest'])) { //following only occurs if user is creating a record
        return '';
    }

    if (strlen($_POST['email']) == 0 || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
        return '';
    }

    $msg = "Dear Sir or Madam,\nThank you for considering our services. Here are the following charges:\n. Monthly charge\n. Annual charge\n. Special package\n Select your preferred payment method.\nYours faithfully,\nCar Park Finder";

    mail($email,"Add Request for Car Park Finder",$msg);

    echo 'Request successfully submitted, please check your e-mail!';

    ?>

</div>

</body>

</html>