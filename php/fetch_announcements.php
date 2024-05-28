<?php
$sql = "SELECT * FROM announcements ORDER BY a_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['a_id'];
        $title = htmlspecialchars($row['a_title']);
        $message = htmlspecialchars($row['a_message']);
        $date = date('M j, Y H:i', strtotime($row['a_date']));

        echo '<div class="announcement-card" data-announcement-id="' . $id . '">';
        echo '<h3>' . $title . '<span class="close-btn">&times;</span></h3>';
        echo '<p>' . $message . '</p>';
        echo '<p><small>Posted on ' . $date . '</small></p>';
        echo '</div>';
    }
} else {
    echo '<p>No announcements found.</p>';
}

$conn->close();
?>
