<?php
include('../database.php');

$sqlPurposes = "SELECT r_purpose, COUNT(*) AS count FROM records GROUP BY r_purpose";
$resultPurposes = $conn->query($sqlPurposes);
$purposesData = [];
$purposesLabels = [];
while ($row = $resultPurposes->fetch_assoc()) {
    $purposesData[] = $row['count'];
    $purposesLabels[] = $row['r_purpose'];
}

$sqlLabRooms = "SELECT r_labroom, COUNT(*) AS count FROM records GROUP BY r_labroom";
$resultLabRooms = $conn->query($sqlLabRooms);
$labRoomsData = [];
$labRoomsLabels = [];
while ($row = $resultLabRooms->fetch_assoc()) {
    $labRoomsData[] = $row['count'];
    $labRoomsLabels[] = $row['r_labroom'];
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
