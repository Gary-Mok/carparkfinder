<?php

echo '<div class="navigation">';
if (isset($_SESSION['username'])) {
    echo '<p>Welcome, ' . $_SESSION['username'] . '!</p>';
}

$links = array(
    'search.php' => 'Main page',
    'create.php' => 'Create',
    'read.php' => 'Read',
    'update.php' => 'Update',
    'delete.php' => 'Delete',
    'logout.php' => 'Log out',
);

$actions = array();
foreach ($links as $file => $label) {
    $actions[] = sprintf('<a href="%s">%s</a>', $file, $label);
}

echo '<p>' . implode(' | ', $actions) . '</p>';
echo '</div>';
