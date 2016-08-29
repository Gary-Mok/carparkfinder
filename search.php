<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/main.css'/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Car Park Finder</title>
</head>

<body class="carpark-finder">

<?php

include 'bootstrap.php';

$elements = array(
    'name' => array(
        'description' => 'Carpark Name',
        'isRequired' => false,
        'type' => 'text',
    ),
    'owner' => array(
        'description' => 'Owner Name',
        'isRequired' => false,
        'type' => 'text',
    ),
    'location' => array(
        'description' => 'Location',
        'isRequired' => false,
        'type' => 'text',
    ),
    'postcode' => array(
        'description' => 'Postcode',
        'isRequired' => false,
        'type' => 'text',
    ),
    'submit' => array(
        'description' => 'Submit',
        'isRequired' => false,
        'type' => 'submit',
        'label' => false,
        'isSearchable' => false,
    ),
);
?>


<h1>Car Park Finder</h1>

<?php
if (!isset($_SESSION['username'])) {
    echo '<div><p><a href="login.php">Log in</a> or <a href="register.php">register</a></p></div>';
} else {
    include 'navigation.php';

    if ($_SESSION['type'] !== "admin") {
        echo '<p><a href="requests.php">Make a request</a></p>';
    }
}
?>

<div class="filter">
    <h2>Search for a car park</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <?php echo generateElements($elements) ?>
    </form>
</div>

<?php if ('POST' === $_SERVER['REQUEST_METHOD']) : ?>
    <div class="result">
        <h1>Result</h1>
        <?php

        $sql = getCarparkSearchQuery($elements, $_REQUEST);
        $query = $db->prepare($sql);
        $check = $query->execute();

        if ($check === false) {
            die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
        }

        echo '<table><tr><th>Name</th><th>Location</th><th>Postcode</th><th>Vacancies</th></tr>';

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr><td>' . $row['name'] . '</td><td>' . $row['location'] . '</td><td>' . $row['postcode'] . '</td><td>' . $row['vacancies'] . '</td></tr>';
        }

        echo '</table>';
        ?>
    </div>
<?php endif; ?>

</body>
</html>