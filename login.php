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

if (isset($_SESSION['username'])) {
    header("Location: search.php");
    exit();
}

?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <label for="username">Username:</label> <input type="text" name="username" id="username" />
    <label for="password">Password:</label> <input type="password" name="password" id="password" />
    <input type="submit" name="submit" value="Login" />
</form>

<p><a href="search.php">Back</a></p>

<?php

if (isset($_POST['submit'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $crypt = "";

    $sql = "SELECT * from members WHERE username LIKE :username LIMIT 1";
    $query = $db->prepare($sql);
    $query->execute(['username' => $username]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (!isset($result['id'])) {
        echo "<p>Invalid username</p>";
    } else {
        $crypt = $result['password'];

        if (password_verify($password, $crypt)) {

            $_SESSION['type'] = $result['type'];
            $_SESSION['username'] = $username;
            header("Location: search.php");

        } else {
            echo "<p>Invalid password</p>";
        }
    }
}

?>

</body>

</html>
