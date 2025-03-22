<?php
require_once 'connect.php';
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$sql = "UPDATE tasks SET ";
$params = [];
$updates = [];
if ($request['title']!='') {
    $updates[] = "title = :title";
    $params[':title'] = $request['title'];
}
$updates[] = "description = :description";
$params[':description'] = $request['description'];
if ($request['status']!='') {
    $updates[] = "status = :status";
    $params[':status'] = $request['status'];
}
$sql .= implode(", ", $updates) . " WHERE id = :id";
$params[':id'] = $request['id'];
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => 'Task updated']);
} else {
    echo json_encode(['error' => 'No task found with the provided ID']);
}