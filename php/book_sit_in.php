<?php
session_start();
include('../database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s_idno = mysqli_real_escape_string($conn, $_POST['s_idno']);
    $r_purpose = mysqli_real_escape_string($conn, $_POST['r_purpose']);
    $r_labroom = mysqli_real_escape_string($conn, $_POST['r_labroom']);
    $time_in = date('Y-m-d H:i:s'); 

    $query = "INSERT INTO records (s_idno, r_purpose, r_labroom, time_in) VALUES ('$s_idno', '$r_purpose', '$r_labroom', '$time_in')";

    if ($conn->query($query) === TRUE) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false, 'error' => $conn->error);
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
