<?php
include 'config.php';

// تحديد طريقة الطلب
$request_method = $_SERVER["REQUEST_METHOD"];
$request = isset($_GET['request']) ? $_GET['request'] : '';

// تحليل المسار لتحديد الوظيفة المطلوبة
switch ($request_method) {
    case 'GET':
        if ($request == 'students') {
            readStudents();
        } else {
            response(400, "Invalid Request");
        }
        break;

    case 'POST':
        if ($request == 'students') {
            createStudent();
        } else {
            response(400, "Invalid Request");
        }
        break;

    case 'PUT':
        if ($request == 'students') {
            updateStudent();
        } else {
            response(400, "Invalid Request");
        }
        break;

    case 'DELETE':
        if ($request == 'students') {
            deleteStudent();
        } else {
            response(400, "Invalid Request");
        }
        break;

    default:
        response(405, "Method Not Allowed");
        break;
}

// وظيفة لقراءة السجلات
function readStudents() {
    global $conn;
    $sql = "SELECT * FROM Students";
    $result = $conn->query($sql);
    $students = array();
    while ($row = $result->fetch_assoc()) {
        array_push($students, $row);
    }
    response(200, $students);
    $conn->close();
}

// وظيفة لإنشاء سجل طالب
function createStudent() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"));
    $first_name = $data->first_name;
    $last_name = $data->last_name;
    $date_of_birth = $data->date_of_birth;
    $address = $data->address;
    $sql = "INSERT INTO Students (first_name, last_name, date_of_birth , address ) 
            VALUES ('$first_name', '$last_name', '$date_of_birth',  '$address' )";
    if ($conn->query($sql) === TRUE) {
        response(201, array("message" => "Student created successfully"));
    } else {
        response(500, array("message" => "Error: " . $conn->error));
    }
    $conn->close();
}

// وظيفة لتحديث سجل طالب
function updateStudent() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->student_id;
    $first_name = $data->first_name;
    $last_name = $data->last_name;
    $date_of_birth = $data->date_of_birth;
    $address = $data->address;
    $sql = "UPDATE Students SET 
            first_name='$first_name', 
            last_name='$last_name', 
            date_of_birth='$date_of_birth', 
            address='$address', 
            WHERE student_id=$id";
    if ($conn->query($sql) === TRUE) {
        response(200, array("message" => "Student updated successfully"));
    } else {
        response(500, array("message" => "Error: " . $conn->error));
    }
    $conn->close();
}

// وظيفة لحذف سجل طالب
function deleteStudent() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->student_id;
    $sql = "DELETE FROM Students WHERE student_id=$id";
    if ($conn->query($sql) === TRUE) {
        response(200, array("message" => "Student deleted successfully"));
    } else {
        response(500, array("message" => "Error: " . $conn->error));
    }
    $conn->close();
}

// وظيفة لإرسال الاستجابة
function response($status, $data) {
    header("Content-Type: application/json");
    http_response_code($status);
    echo json_encode($data);
    exit();
}
?>
