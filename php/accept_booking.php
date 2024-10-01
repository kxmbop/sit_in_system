<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bookingId'])) {
    $bookingId = $_POST['bookingId'];
    
    include('../database.php');
    
    $sql = "UPDATE booking SET b_status = 'accepted', b_ack_dt = CURRENT_TIMESTAMP WHERE b_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);
    if ($stmt->execute()) {
        $sql = "INSERT INTO records (s_idno, r_purpose, r_labroom, time_in) 
                SELECT student.s_idno, booking.b_purpose, booking.b_labroom, booking.b_time_in 
                FROM booking 
                JOIN student ON booking.s_id = student.s_id 
                WHERE booking.b_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bookingId);
        if ($stmt->execute()) {
            echo "Booking request accepted successfully!";
        } else {
            echo "Error accepting booking request: " . $stmt->error;
        }
    } else {
        echo "Error accepting booking request: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>

