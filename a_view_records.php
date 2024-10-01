<?php
session_start();
include('database.php');

if(isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    $admin_user = $_SESSION['admin_user'];
    $admin_name = $_SESSION['admin_name'];
    $admin_email = $_SESSION['admin_email'];
} else {
    header("Location: admin_login.php");
    exit;
}

if (isset($_POST['r_id'])) {
    $r_id = $_POST['r_id']; 

    $sql = "UPDATE records SET time_out = current_timestamp() WHERE r_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $r_id); 
    if ($stmt->execute()) {
        $updateSql = "UPDATE student SET session = session - 1 WHERE s_idno = (
            SELECT s_idno FROM records WHERE r_id = ?
        )";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('i', $r_id);
        
        if ($updateStmt->execute()) {
            echo "Time out recorded successfully for record ID " . $r_id;
        } else {
            echo "Error updating student session count: " . $conn->error;
        }
    } else {
        echo "Error occurred while recording time out: " . $stmt->error;
    }
    $stmt->close();
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body onload="showContent('search')">
    <div class="container">
        <nav>
            <div class="navbar">
                <div class="logo">
                    <h1><?php echo isset($admin_name) ? $admin_name : 'undefined'; ?>!</h1>
                </div>
                <ul class="nav-class">
                    <li class="inactive-tab">
                        <a href="a_search.php">
                            <i class="fas fa-search"></i>
                            <span class="nav-item">Search</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                        <a href="a_delete.php">
                            <i class="fas fa-trash-alt"></i>
                            <span class="nav-item">Delete</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                    <a href="a_reset_pass.php">
                            <i class="fa-solid fa-unlock-keyhole"></i>
                            <span class="nav-item">Reset Password</span>
                        </a>
                    </li>
                    <!--<li class="inactive-tab">
                    <a href="a_reset_session.php">
                            <i class="fa-solid fa-arrows-rotate"></i>
                            <span class="nav-item">Reset Session</span>
                        </a>
                    </li>-->
                    <li class="current-tab">
                    <a href="a_view_records.php">
                            <i class="fa-solid fa-eye"></i>
                            <span class="nav-item">View Sit-In Records</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                    <a href="a_generate_reports.php">
                            <i class="fa-solid fa-chart-line"></i>
                            <span class="nav-item">Generate Reports</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                    <a href="a_post.php">
                            <i class="fa-solid fa-bullhorn"></i>
                            <span class="nav-item">Post Announcement</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                    <a href="a_booking.php">
                        <i class="fa-regular fa-hand-point-up"></i>
                            <span class="nav-item">Booking Request </span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                    <a href="a_view_feedback.php">
                        <i class="fa-solid fa-comments"></i>
                            <span class="nav-item">View Feedback</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php" class="logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="nav-item">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <section class="main">
            <div class="main-body">
                <div id="sit-in" class="content-section">
                    <h3 style="font-size: 28px; font-weight: bold; text-align: left;">View Sit-In Records</h3>
                    <div class="main-body">
                        <div class="profile-edit">
                            <?php
                                $sql = "SELECT records.*, student.s_name, student.s_course, student.session 
                                        FROM records 
                                        JOIN student ON records.s_idno = student.s_idno";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo '<table class="records-header">';
                                    echo '<tr><th>Student ID</th><th>Name</th><th>Course</th><th>Session Left</th><th>Purpose</th><th>Lab Room</th><th>Time In</th><th>Action</th><th>Record ID</th></tr>';
                                    echo '</table>';
                                    echo '<div class="records-tbody">';
                                    echo '<table class="records-table">';
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row["time_out"] === null) {
                                            echo '<tr>';
                                            echo '<td>' . $row["s_idno"] . '</td>';
                                            echo '<td>' . $row["s_name"] . '</td>';
                                            echo '<td>' . $row["s_course"] . '</td>';
                                            echo '<td>' . $row["session"] . '</td>';
                                            echo '<td>' . $row["r_purpose"] . '</td>';
                                            echo '<td>' . $row["r_labroom"] . '</td>';
                                            echo '<td>' . $row["time_in"] . '</td>';
                                            echo '<td><i class="fas fa-hourglass-end action-icon" onclick="timeout(' . $row["r_id"] . ')"></i></td>';
                                            echo '<td>' . $row["r_id"] . '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    echo '</table>';
                                    echo '</div';
                                } else {
                                    echo "No records found.";
                                }
                            ?>
                        </div>
                    </div>    
                </div>
            </div>
        </section>
        
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

<script>
    function timeout(r_id) {
        $.ajax({
            url: 'admin_dashboard.php', 
            method: 'POST',
            data: { r_id: r_id },
            success: function(response) {
                alert('Time out recorded successfully for record ID ' + r_id);
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Error occurred while recording time out. Please try again later.');
                console.error(xhr.responseText);
            }
        });
    }
</script>


</body>
</html>