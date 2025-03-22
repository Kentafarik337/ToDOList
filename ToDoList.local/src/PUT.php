<?php
require_once 'connect.php';
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (!isset($data['id'])) {
    echo json_encode(array("error" => "ID is required"));
    exit();
}
$sql = "UPDATE tasks SET ";
$params = [];
$updates = [];
if (isset($data['title'])) {
    $updates[] = "title = :title";
    $params[':title'] = $data['title'];
}
if (isset($data['description'])) {
    $updates[] = "description = :description";
    $params[':description'] = $data['description'];
}
if (isset($data['status'])) {
    $updates[] = "status = :status";
    $params[':status'] = $data['status'];
}
if (empty($updates)) {
    echo json_encode(['error' => 'No fields to update']);
    exit;
}
$sql .= implode(", ", $updates) . " WHERE id = :id";
$params[':id'] = $data['id'];
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => 'Task updated successfully']);
    } else {
        echo json_encode(['error' => 'No task found with the provided ID']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}