<?php

echo '<div class="navigation">';

echo '<p>Welcome, ' . $_SESSION['username'] . '!</p>';

echo '<p><a href="search.php">Main page</a> | <a href="create.php">Create</a> | <a href="read.php">Read</a> | <a href="update.php">Update</a> | <a href="delete.php">Delete</a> | <a href="logout.php">Log out</a></p>';

echo '</div>';