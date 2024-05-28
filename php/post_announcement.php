<?php
session_start();
include('../database.php');

header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'error' => 'Admin not logged in']);
    exit;
}

if (!isset($_POST['title']) || !isset($_POST['message'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
    exit;
}

$title = $_POST['title'];
$message = $_POST['message'];

$query = "INSERT INTO announcements (a_title, a_message) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $title, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to post announcement']);
}

$stmt->close();
$conn->close();
?>
