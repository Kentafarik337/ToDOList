<?php
require_once 'connect.php';
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$id = $request['id'];
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->execute(array("id"=> $id));
$task = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($task) {
    echo json_encode($task);
} else {
    echo json_encode(array("error" => "Task not found"));
}
?>  