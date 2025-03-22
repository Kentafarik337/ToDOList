<?php
require_once 'connect.php';
$stmt = $pdo->query("SELECT * FROM tasks");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($tasks);
?>