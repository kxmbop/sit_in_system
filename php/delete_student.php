<?php
include('../database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $s_idno = $_POST['s_idno'];

    $sql = "DELETE FROM student WHERE s_idno = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $s_idno);
        if ($stmt->execute()) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false, 'error' => 'Failed to execute the query.');
        }
        $stmt->close();
    } else {
        $response = array('success' => false, 'error' => 'Failed to prepare the statement.');
    }

    $conn->close();
    echo json_encode($response);
}
?>