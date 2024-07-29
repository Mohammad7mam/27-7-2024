<?php
include 'config.php';

$sql = "SELECT * FROM Students";
$result = $conn->query($sql);

$students = array();
while($row = $result->fetch_assoc()) {
    array_push($students, $row);
}

echo json_encode($students);

$conn->close();
?>
