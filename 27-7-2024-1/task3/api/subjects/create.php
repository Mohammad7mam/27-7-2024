<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/Subject.php';

$database = new Database();
$db = $database->getConnection();

$subject = new Subject($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    !empty($data->description) &&
    !empty($data->teacher_id)
) {
    $subject->name = $data->name;
    $subject->description = $data->description;
    $subject->teacher_id = $data->teacher_id;

    if ($subject->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Subject created successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create subject."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
