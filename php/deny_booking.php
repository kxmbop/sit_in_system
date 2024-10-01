<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bookingId'])) {
    $bookingId = $_POST['bookingId'];
    
    include('../database.php'); 
    
    $sql = "UPDATE booking SET b_status = 'denied', b_ack_dt = CURRENT_TIMESTAMP WHERE b_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);
    if ($stmt->execute()) {
        echo "Booking request denied successfully!";
    } else {
        echo "Error denying booking request: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
