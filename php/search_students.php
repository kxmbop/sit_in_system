<?php
session_start();
include('../database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchTerm'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    $queryStudent = "SELECT * FROM student WHERE s_idno LIKE '%$searchTerm%' LIMIT 1";
    error_log("Query for student details: " . $queryStudent);

    $resultStudent = $conn->query($queryStudent);

    if ($resultStudent) {
        if ($resultStudent->num_rows > 0) {
            $studentDetails = $resultStudent->fetch_assoc();

            $response = array(
                'success' => true,
                's_idno' => $studentDetails['s_idno'],
                's_name' => $studentDetails['s_name'],
                's_email' => $studentDetails['s_email'],
                's_course' => $studentDetails['s_course'],
                's_age' => $studentDetails['s_age'],
                's_address' => $studentDetails['s_address'],
                's_gender' => $studentDetails['s_gender'],
                'session' => $studentDetails['session']
            );

            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'error' => 'Student not found');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'error' => 'Error fetching student details');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
