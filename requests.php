<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css'/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Requests</title>
</head>

<body>

<?php

include 'bootstrap.php';

if (!isset($_SESSION['username'])) {
    header("Location: search.php");
    exit();
}

?>

<h1>Requests</h1>

<?php

include 'navigation.php';

if ($_SESSION['type'] == "owner") {
    echo '<p><a href="createrequest.php">Add request</a></p>';
    echo '<p><a href="updaterequest.php">Edit request</a></p>';
    echo '<p>Delete request</p>';
} else {
    echo 'You do not have the administrative right to view this page. Please return to the <a href="search.php">main page</a>.';
    return '';
}

?>

</body>

</html>