<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css'/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Requests</title>
</head>

<body>

<h1>Requests</h1>

<?php

include 'bootstrap.php';

if (!isset($_SESSION['username'])) {
    header("Location: search.php");
    exit();
}

if ($_SESSION['type'] == "owner") {
    echo '<p><a href="createrequest.php">Add request</a></p>';
}

?>

<p><a href="search.php">Back</a></p>

</body>

</html>