<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../students/Student.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    !empty($data->date_of_birth) &&
    !empty($data->address) &&
    !empty($data->contact_info)
) {
    $student->name = $data->name;
    $student->date_of_birth = $data->date_of_birth;
    $student->address = $data->address;
    $student->contact_info = $data->contact_info;

    if ($student->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Student was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create student."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create student. Data is incomplete."));
}
?>
