<?php
require_once 'connect.php';
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$sql = "UPDATE tasks SET ";
$params = [];
$updates = [];
$sqlCheck = "SELECT id FROM tasks WHERE id = :id";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([':id' => $request['id']]);
if ($stmtCheck->rowCount() == 0) {
    echo json_encode(['error' => 'No task found with the provided ID']);
    exit;
}
if ($request['title']!='' && strlen($request['title']<255)) {
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
echo json_encode(['success' => 'Task updated']);