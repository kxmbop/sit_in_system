<?php
<<<<<<< HEAD
if (isset($_POST['studentId'], $_POST['purpose'], $_POST['labroom'], $_POST['pcno'], $_POST['timeIn'])) {
    $studentId = $_POST['studentId'];
    $purpose = $_POST['purpose'];
    $labroom = $_POST['labroom'];
    $pcno = $_POST['pcno'];
=======
if (isset($_POST['studentId'], $_POST['purpose'], $_POST['labroom'], $_POST['timeIn'])) {
    $studentId = $_POST['studentId'];
    $purpose = $_POST['purpose'];
    $labroom = $_POST['labroom'];
>>>>>>> 3f34db8fa219f017bd8bdeaebf451d1a172a2105
    $timeIn = $_POST['timeIn'];

    include('../database.php'); 

<<<<<<< HEAD
    $sql = "INSERT INTO booking (s_id, b_purpose, b_labroom, b_pcno, b_time_in) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiis", $studentId, $purpose, $labroom, $pcno, $timeIn);
=======
    $sql = "INSERT INTO booking (s_id, b_purpose, b_labroom, b_time_in) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isis", $studentId, $purpose, $labroom, $timeIn);
>>>>>>> 3f34db8fa219f017bd8bdeaebf451d1a172a2105
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
