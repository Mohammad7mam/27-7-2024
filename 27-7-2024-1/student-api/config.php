<?php
$host = 'localhost';
$db = 'StudentDB';
$user = 'root';
$password = 'yourpassword';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
