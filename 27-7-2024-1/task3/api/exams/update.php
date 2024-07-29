<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/Exam.php';

$database = new Database();
$db = $database->getConnection();

$exam = new Exam($db);

$data = json_decode(file_get_contents("php://input"));

$exam->id = $data->id;

if (
    !empty($data->subject_id) ||
    !empty($data->date) ||
    !empty($data->max_score)
) {
    if (!empty($data->subject_id)) {
        $exam->subject_id = $data->subject_id;
    }
    if (!empty($data->date)) {
        $exam->date = $data->date;
    }
    if (!empty($data->max_score)) {
        $exam->max_score = $data->max_score;
    }

    if ($exam->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Exam updated successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update exam."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
