<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../objects/Student.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

$student->id = isset($_GET['id']) ? $_GET['id'] : die();

$student->readOne();

if ($student->name != null) {
    $student_arr = array(
        "id" => $student->id,
        "name" => $student->name,
        "class" => $student->class,
        "date_of_birth" => $student->date_of_birth,
        "address" => $student->address,
        "contact_info" => $student->contact_info
    );

    http_response_code(200);
    echo json_encode($student_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Student not found."));
}
?>
