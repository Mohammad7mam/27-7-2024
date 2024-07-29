<?php
header("Content-Type: application/json");
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'POST':
        createStudent($input);
        break;
    case 'GET':
        if (isset($_GET['id'])) {
            getStudent($_GET['id']);
        } else {
            getStudents();
        }
        break;
    case 'PUT':
        if (isset($_GET['id'])) {
            updateStudent($_GET['id'], $input);
        }
        break;
    case 'DELETE':
        if (isset($_GET['id'])) {
            deleteStudent($_GET['id']);
        }
        break;
    default:
        echo json_encode(['message' => 'Invalid Request Method']);
        break;
}

function createStudent($data) {
    global $conn;
    $name = $data['name'];
    $dob = $data['date_of_birth'];
    $address = $data['address'];
    $contact = $data['contact_information'];

    $sql = "INSERT INTO students (name, date_of_birth, address, contact_information) VALUES ('$name', '$dob', '$address', '$contact')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Student created successfully']);
    } else {
        echo json_encode(['message' => 'Error: ' . $conn->error]);
    }
}

function getStudents() {
    global $conn;
    $sql = "SELECT * FROM students";
    $result = $conn->query($sql);

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode($students);
}

function getStudent($id) {
    global $conn;
    $sql = "SELECT * FROM students WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['message' => 'Student not found']);
    }
}

function updateStudent($id, $data) {
    global $conn;
    $name = $data['name'];
    $dob = $data['date_of_birth'];
    $address = $data['address'];
    $contact = $data['contact_information'];

    $sql = "UPDATE students SET name = '$name', date_of_birth = '$dob', address = '$address', contact_information = '$contact' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Student updated successfully']);
    } else {
        echo json_encode(['message' => 'Error: ' . $conn->error]);
    }
}

function deleteStudent($id) {
    global $conn;
    $sql = "DELETE FROM students WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Student deleted successfully']);
    } else {
        echo json_encode(['message' => 'Error: ' . $conn->error]);
    }
}
?>
