<?php
include('../database.php');

$date = isset($_GET['date']) ? $_GET['date'] : null;

if ($date) {
    $sqlPurposes = "SELECT r_purpose, COUNT(*) AS count FROM records WHERE DATE(time_in) = ? GROUP BY r_purpose";
    $stmt = $conn->prepare($sqlPurposes);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $resultPurposes = $stmt->get_result();
    $purposesData = [];
    $purposesLabels = [];
    while ($row = $resultPurposes->fetch_assoc()) {
        $purposesData[] = $row['count'];
        $purposesLabels[] = $row['r_purpose'];
    }
    $stmt->close();

    $sqlLabRooms = "SELECT r_labroom, COUNT(*) AS count FROM records WHERE DATE(time_in) = ? GROUP BY r_labroom";
    $stmt = $conn->prepare($sqlLabRooms);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $resultLabRooms = $stmt->get_result();
    $labRoomsData = [];
    $labRoomsLabels = [];
    while ($row = $resultLabRooms->fetch_assoc()) {
        $labRoomsData[] = $row['count'];
        $labRoomsLabels[] = $row['r_labroom'];
    }
    $stmt->close();
} else {
    $purposesData = [];
    $purposesLabels = [];
    $labRoomsData = [];
    $labRoomsLabels = [];
}

$response = [
    'purposesData' => $purposesData,
    'purposesLabels' => $purposesLabels,
    'labRoomsData' => $labRoomsData,
    'labRoomsLabels' => $labRoomsLabels
];

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
