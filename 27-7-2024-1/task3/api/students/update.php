<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/Student.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

$data = json_decode(file_get_contents("php://input"));

$student->id = $data->id;

if (
    !empty($data->name) ||
    !empty($data->class) ||
    !empty($data->date_of_birth) ||
    !empty($data->address) ||
    !empty($data->contact_info)
) {
    if (!empty($data->name)) {
        $student->name = $data->name;
    }
    if (!empty($data->class)) {
        $student->class = $data->class;
    }
    if (!empty($data->date_of_birth)) {
        $student->date_of_birth = $data->date_of_birth;
    }
    if (!empty($data->address)) {
        $student->address = $data->address;
    }
    if (!empty($data->contact_info)) {
        $student->contact_info = $data->contact_info;
    }

    if ($student->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Student updated successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update student."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
