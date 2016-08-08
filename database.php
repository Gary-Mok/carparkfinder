<?php

$db = new mysqli('localhost', 'root', 'root', 'CARPARKFINDER'); //connects to mysql database

if ($db->connect_errno !== 0) {
    throw new Exception(sprintf('Unable to connect to database [%s]', $db->connect_error)); //error message for failed connection
}