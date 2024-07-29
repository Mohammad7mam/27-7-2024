<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../objects/Exam.php';

$database = new Database();
$db = $database->getConnection();

$exam = new Exam($db);

$exam->id = isset($_GET['id']) ? $_GET['id'] : die();

$exam->readOne();

if ($exam->subject_id != null) {
    $exam_arr = array(
        "id" => $exam->id,
        "subject_id" => $exam->subject_id,
        "date" => $exam->date,
        "max_score" => $exam->max_score
    );

    http_response_code(200);
    echo json_encode($exam_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Exam not found."));
}
?>
س