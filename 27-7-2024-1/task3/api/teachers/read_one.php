<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../objects/Teacher.php';

$database = new Database();
$db = $database->getConnection();

$teacher = new Teacher($db);

$teacher->id = isset($_GET['id']) ? $_GET['id'] : die();

$teacher->readOne();

if ($teacher->name != null) {
    $teacher_arr = array(
        "id" => $teacher->id,
        "name" => $teacher->name,
        "contact_info" => $teacher->contact_info
    );

    http_response_code(200);
    echo json_encode($teacher_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Teacher not found."));
}
?>
