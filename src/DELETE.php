<?php
require_once 'connect.php';
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$id = $request['id'];
$stmt = $pdo->prepare("DELETE FROM tasks WHERE id=:id");
$stmt->execute(array("id"=> $id));
if ($stmt->rowCount() > 0) {
    echo json_encode(array("success" => "Task deleted successfully"));
} else {
    echo json_encode(array("error" => "Task not found"));
}
?>