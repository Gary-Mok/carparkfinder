<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Car Park Finder - Register
    </title>
</head>

<body>

<h1>Register a new user</h1>

<?php

include 'bootstrap.php';

$usernameErr = $passwordErr = '';

$username = $password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    if (strlen($_POST['username']) == 0) {
        $usernameErr = 'Username is required';
    } else {
        $username = input($_POST['username']);
    }

    if (strlen($_POST['password']) == 0) {
        $passwordErr = 'Password is required';
    } else {
        $password = input($_POST['password']);
    }

}

session_start();

?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <label for="username">Username:</label> <input type="text" name="username" id="username" />
    <span>* <?php echo $usernameErr;?></span>
    <br><br>
    <label for="password">Password:</label> <input type="password" name="password" id="password" />
    <span>* <?php echo $passwordErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="Register" />
</form>

<?php
if (!isset($_POST['submit'])) { //following only occurs if user is creating a record
    return '';
}


if (strlen($_POST['username']) == 0) {
    return '';
}

if(strlen($_POST['password']) == 0) {
    return '';
}

$exists = 0;
$result = $db->query("SELECT username from members WHERE username = '{$username}' LIMIT 1");
if ($result->num_rows == 1) {
    $exists = 1;
}

if ($exists == 1) {
    echo "<p>Username already exists!</p>";
    echo "<p><a href='register.php'>Retry</a></p>";
} else {
    $encrypt = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT  INTO members (username, password) VALUES ('{$username}', '{$encrypt}')";

    if ($db->query($sql)) {
        $_SESSION['username'] = $username;
        header("Location: search.php");
    } else {
        echo "<p>MySQL error no {$db->errno} : {$db->error}</p>";
        exit();
    }
}
?>

</body>

</html>
