<?php
if (isset($_POST['studentId'], $_POST['purpose'], $_POST['labroom'], $_POST['timeIn'])) {
    $studentId = $_POST['studentId'];
    $purpose = $_POST['purpose'];
    $labroom = $_POST['labroom'];
    $timeIn = $_POST['timeIn'];

    include('../database.php'); 

    $sql = "INSERT INTO booking (s_id, b_purpose, b_labroom, b_time_in) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isis", $studentId, $purpose, $labroom, $timeIn);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Reservation submitted successfully!";
    } else {
        echo "Error submitting reservation: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error: Missing POST data.";
}
?>
