<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/Exam.php';

$database = new Database();
$db = $database->getConnection();

$exam = new Exam($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->subject_id) &&
    !empty($data->date) &&
    !empty($data->max_score)
) {
    $exam->subject_id = $data->subject_id;
    $exam->date = $data->date;
    $exam->max_score = $data->max_score;

    if ($exam->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Exam created successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create exam."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
