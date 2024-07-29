<?php
include 'config.php';

$data = json_decode(file_get_contents("php://input"));
$id = $data->student_id;
$first_name = $data->first_name;
$last_name = $data->last_name;
$date_of_birth = $data->date_of_birth;
$gender = $data->gender;
$email = $data->email;
$phone_number = $data->phone_number;
$address = $data->address;
$enrollment_date = $data->enrollment_date;

$sql = "UPDATE Students SET 
        first_name='$first_name', 
        last_name='$last_name', 
        date_of_birth='$date_of_birth', 
        gender='$gender', 
        email='$email', 
        phone_number='$phone_number', 
        address='$address', 
        enrollment_date='$enrollment_date' 
        WHERE student_id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "Student updated successfully"));
} else {
    echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
}

$conn->close();
?>
