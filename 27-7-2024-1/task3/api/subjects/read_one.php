<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../objects/Subject.php';

$database = new Database();
$db = $database->getConnection();

$subject = new Subject($db);

$subject->id = isset($_GET['id']) ? $_GET['id'] : die();

$subject->readOne();

if ($subject->name != null) {
    $subject_arr = array(
        "id" => $subject->id,
        "name" => $subject->name,
        "description" => $subject->description,
        "teacher_id" => $subject->teacher_id
    );

    http_response_code(200);
    echo json_encode($subject_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Subject not found."));
}
?>
