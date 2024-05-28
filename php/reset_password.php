<?php
session_start();
include('../database.php');

header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'error' => 'Admin not logged in']);
    exit;
}

if (!isset($_POST['s_idno']) || !isset($_POST['newPassword'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
    exit;
}

$s_idno = $_POST['s_idno'];
$newPassword = $_POST['newPassword'];

$query = "UPDATE student SET s_pass = ? WHERE s_idno = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $newPassword, $s_idno);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to reset password']);
}

$stmt->close();
$conn->close();
?>
