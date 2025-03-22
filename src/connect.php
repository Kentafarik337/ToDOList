<?php

$host ='MySQL-8.2';
$dbname ='pdo';
$username ='root';
$password = '';
try{
$pdo = new PDO("mysql:host=$host; dbname=$dbname;", $username, $password);
}
catch(PDOException $e)
{
    echo "Database connection error: ";
}
?>
