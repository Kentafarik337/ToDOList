<?php
require_once 'connect.php';
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$sql = "UPDATE tasks SET ";
$params = [];
$updates = [];
if (isset($request['title'])) {
    $updates[] = "title = :title";
    $params[':title'] = $request['title'];
}
if (isset($request['description'])) {
    $updates[] = "description = :description";
    $params[':description'] = $request['description'];
}
if (isset($request['status'])) {
    $updates[] = "status = :status";
    $params[':status'] = $request['status'];
}
if (empty($updates)) {
    echo json_encode(['error' => 'No fields to update']);
    exit;
}
$sql .= implode(", ", $updates) . " WHERE id = :id";
$params[':id'] = $request['id'];
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => 'Task updated successfully']);
} else {
    echo json_encode(['error' => 'No task found with the provided ID']);
}