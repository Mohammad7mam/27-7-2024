<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../objects/Exam.php';

$database = new Database();
$db = $database->getConnection();

$exam = new Exam($db);

$stmt = $exam->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $exams_arr = array();
    $exams_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $exam_item = array(
            "id" => $id,
            "subject_id" => $subject_id,
            "date" => $date,
            "max_score" => $max_score
        );

        array_push($exams_arr["records"], $exam_item);
    }

    http_response_code(200);
    echo json_encode($exams_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No exams found."));
}
?>
