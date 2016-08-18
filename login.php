<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css' />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Car Park Finder - Register
    </title>
</head>

<body>

<h1>Log in</h1>

<?php

include 'bootstrap.php';

session_start();

if (!isset($_POST['submit'])){
    ?>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <label for="username">Username:</label> <input type="text" name="username" id="username" /><br />
        <label for="password">Password:</label> <input type="password" name="password" id="password" /><br />
        <input type="submit" name="submit" value="Login" />
    </form>
    <?php
} else {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $crypt = "";

    $sql = "SELECT * from members WHERE username LIKE '{$username}' LIMIT 1";
    $result = $db->query($sql);
    if (!$result || !$result->num_rows == 1) {
        echo "<p>Invalid username</p>";
        echo "<p><a href='login.php'>Retry</a></p>";
    } else {
        $row = $result->fetch_assoc();
        $crypt = $row['password'];

        if (password_verify($password, $crypt)) {

            $_SESSION['username'] = $username;
            header("Location: search.php");

        } else {
            echo "<p>Invalid password</p>";
            echo "<p><a href='login.php'>Retry</a></p>";
        }
    }
}

?>

</body>

</html>
