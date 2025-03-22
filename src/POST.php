<?php
require_once 'connect.php';
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$title = $request['title'];
$description = $request['description'];
$status = $request['status'];

if ($status == '') 
{
    $status=0;
}else if ($status != 0 && $status != 1) {
    echo json_encode(array("error" => "Status must be 0 or 1"));
    exit;
}
if (strlen($title)>255)
{
    echo json_encode(array("error" => "Title"));
    exit;
}
$stmt = $pdo->prepare("INSERT INTO tasks (title, description, status) VALUES (:title, :description, :status)");
$stmt->execute(array("title"=> $title,"description"=> $description, "status"=> $status));
echo json_encode(array("success" => "Task update"));