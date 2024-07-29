<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../students/Student.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

$data = json_decode(file_get_contents("php://input"));

$student->id = $data->id;

$student->name = $data->name;
$student->date_of_birth = $data->date_of_birth;
$student->address = $data->address;
$student->contact_info = $data->contact_info;

if ($student->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Student updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "He was unable to update the student."));
}
?>
