<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../objects/Subject.php';

$database = new Database();
$db = $database->getConnection();

$subject = new Subject($db);

$stmt = $subject.read();
$num = $stmt->rowCount();

if ($num > 0) {
    $subjects_arr = array();
    $subjects_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $subject_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "teacher_id" => $teacher_id
        );

        array_push($subjects_arr["records"], $subject_item);
    }

    http_response_code(200);
    echo json_encode($subjects_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No subjects found."));
}
?>
