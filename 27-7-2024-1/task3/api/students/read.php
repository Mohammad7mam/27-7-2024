<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../objects/Student.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

$stmt = $student->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $students_arr = array();
    $students_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $student_item = array(
            "id" => $id,
            "name" => $name,
            "class" => $class,
            "date_of_birth" => $date_of_birth,
            "address" => $address,
            "contact_info" => $contact_info
        );

        array_push($students_arr["records"], $student_item);
    }

    http_response_code(200);
    echo json_encode($students_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No students found."));
}
?>
