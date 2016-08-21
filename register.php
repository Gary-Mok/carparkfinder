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

if (isset($_SESSION['username'])) {
    echo '<p>Please <a href="logout.php">log out</a> before registering a new user.</p>';
    return '';
}

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

?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <label for="username">Username:</label> <input type="text" name="username" id="username" />
    <span>* <?php echo $usernameErr;?></span><br/>
    <label for="password">Password:</label> <input type="password" name="password" id="password" />
    <span>* <?php echo $passwordErr;?></span><br/>
    <label for="type">Account type:</label> Visitor <input type="radio" name="type" id="type" value="visitor"> Car Park Owner <input type="radio" name="type" id="type" value="owner"> Administrator <input type="radio" name="type" id="type" value="admin"><br/>
    <input type="submit" name="submit" value="Register" />
</form>

<p><a href="search.php">Back</a></p>

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

$userCheck = "SELECT * from members WHERE username = '{$username}' LIMIT 1";
$query = $db->prepare($userCheck);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

if (isset($result['id'])) {
    echo "<p>Username already exists!</p>";
    echo "<p><a href='register.php'>Retry</a></p>";
} else {
    $encrypt = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO members (username, password) VALUES ('{$username}', '{$encrypt}')";
    $query = $db->prepare($sql);

    if ($query->execute()) {
        $_SESSION['username'] = $username;
        header("Location: search.php");
    } else {
        echo "<p>MySQL error no {$db->errorCode()} : {$db->errorInfo()}</p>";
        exit();
    }
}
?>

</body>

</html>
