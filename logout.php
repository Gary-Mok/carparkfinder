<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: search.php");
}

unset($_SESSION['username']);
header("Location: search.php");
exit;
