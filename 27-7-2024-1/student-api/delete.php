<?php
include 'config.php';

$data = json_decode(file_get_contents("php://input"));
$id = $data->student_id;

$sql = "DELETE FROM Students WHERE student_id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "Student deleted successfully"));
} else {
    echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
}

$conn->close();
?>
