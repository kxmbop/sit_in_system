<?php
session_start();
include('../database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['studentId'])) {
    $studentId = mysqli_real_escape_string($conn, $_POST['studentId']);

    $queryRecords = "SELECT * FROM records WHERE s_idno = '$studentId'";
    error_log("Query for records: " . $queryRecords);

    $resultRecords = $conn->query($queryRecords);
    if ($resultRecords) {
        $records = array();
        while ($record = $resultRecords->fetch_assoc()) {
            $records[] = array(
                'r_purpose' => $record['r_purpose'],
                'r_labroom' => $record['r_labroom'],
                'time_in' => $record['time_in'],
                'time_out' => $record['time_out']
            );
        }
        $response = array('success' => true, 'records' => $records);
    } else {
        $response = array('success' => false, 'error' => 'Error fetching records');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
