<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/Teacher.php';

$database = new Database();
$db = $database->getConnection();

$teacher = new Teacher($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    !empty($data->contact_info)
) {
    $teacher->name = $data->name;
    $teacher->contact_info = $data->contact_info;

    if ($teacher->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Teacher created successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create teacher."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
