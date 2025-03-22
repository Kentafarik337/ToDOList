<?php

$host ='localhost';
$dbname ='pdo';
$username ='root';
$password = '1111111';
try{
$pdo = new PDO("mysql:host=$host; dbname=$dbname;", $username, $password);
}
catch(PDOException $e)
{
    echo "Database connection error: ". $e->getMessage();
}
?>
