<?php
    require_once 'connect.php';
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    if (!isset($data['id'])) {
            echo json_encode(array("error" => "ID is required"));
            exit();
        }
    $id = $data['id'];
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
    $stmt->execute(array("id"=> $id));
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($task) {
        echo json_encode($task);
    } else {
        echo json_encode(array("error" => "Task not found"));
    }
?>  