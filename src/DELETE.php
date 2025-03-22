<?php
require_once 'connect.php';
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (!isset($data['id'])) {
        echo json_encode(array("error" => "ID is required"));
        exit();
    }
$id = $data['id'];
$stmt = $pdo->prepare("DELETE FROM tasks WHERE id=:id");
$stmt->execute(array("id"=> $id));
if ($stmt->rowCount() > 0) {
    echo json_encode(array("success" => "Task deleted successfully"));
} else {
    echo json_encode(array("error" => "No task found with the given ID"));
}
?>