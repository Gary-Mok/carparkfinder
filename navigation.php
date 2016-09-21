<?php

if ($_SESSION['type'] == "admin") {

    echo '<div class="navigation">';

    echo '<p>Welcome, ' . $_SESSION['username'] . '!</p>';

    echo '<p><a href="search.php">Main page</a> | <a href="create.php">Create</a> | <a href="read.php">Read</a> | <a href="update.php">Update</a> | <a href="delete.php">Delete</a> | <a href="credit.php">Transactions</a> | <a href="creditadmin.php">Transactions (all)</a> | <a href="logout.php">Log out</a></p>';

    echo '</div>';

} elseif ($_SESSION['type'] == "owner") {

    echo '<div class="navigation">';

    echo '<p>Welcome, ' . $_SESSION['username'] . '!</p>';

    echo '<p><a href="search.php">Main page</a> | <a href="read.php">Read</a> | <a href="credit.php">Transactions</a> | <a href="logout.php">Log out</a></p>';

    echo '</div>';

} else {

    echo '<div class="navigation">';

    echo '<p>Welcome, ' . $_SESSION['username'] . '!</p>';

    echo '<p><a href="logout.php">Log out</a></p>';

    echo '</div>';

}
