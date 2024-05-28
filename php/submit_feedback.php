<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recordId'], $_POST['feedbackMessage'], $_POST['studentId'])) {
    $recordId = intval($_POST['recordId']);
    $feedbackMessage = htmlspecialchars($_POST['feedbackMessage']);
    $studentId = intval($_POST['studentId']);

    include('../database.php');

    $sql = "INSERT INTO feedback (r_id, s_id, f_message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param("iis", $recordId, $studentId, $feedbackMessage);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Feedback submitted successfully!";
    } else {
        echo "Error submitting feedback: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error: Missing or invalid POST data (recordId, feedbackMessage, or studentId).";
}
?>
