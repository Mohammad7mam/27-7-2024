<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/Teacher.php';

$database = new Database();
$db = $database->getConnection();

$teacher = new Teacher($db);

$data = json_decode(file_get_contents("php://input"));

$teacher->id = $data->id;

if ($teacher->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "Teacher deleted successfully."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete teacher."));
}
?>
