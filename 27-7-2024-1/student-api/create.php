<?php
include 'config.php';

$data = json_decode(file_get_contents("php://input"));

$first_name = $data->first_name;
$last_name = $data->last_name;
$date_of_birth = $data->date_of_birth;
$gender = $data->gender;
$email = $data->email;
$phone_number = $data->phone_number;
$address = $data->address;
$enrollment_date = $data->enrollment_date;

$sql = "INSERT INTO Students (first_name, last_name, date_of_birth, gender, email, phone_number, address, enrollment_date) 
        VALUES ('$first_name', '$last_name', '$date_of_birth', '$gender', '$email', '$phone_number', '$address', '$enrollment_date')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "Student created successfully"));
} else {
    echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
}

$conn->close();
?>
