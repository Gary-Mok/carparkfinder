<?php

$host = 'localhost';

$dbname = 'CARPARKFINDER';

$user = 'root';

$pass = 'root';

$db =  new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //connects to mysql database

