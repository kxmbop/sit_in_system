<?php
include('../database.php'); 

if (isset($_POST['announcement_id'])) {
    $announcement_id = $_POST['announcement_id'];

    $sql = "DELETE FROM announcements WHERE a_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $announcement_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Announcement deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete announcement.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
