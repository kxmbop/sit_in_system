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
                    <!--<li class="inactive-tab" type="hidden">
                    <a href="a_reset_session.php">
                            <i class="fa-solid fa-arrows-rotate"></i>
                            <span class="nav-item">Reset Session</span>
                        </a>
                    </li>-->
                    <li class="inactive-tab">
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
                    <li class="current-tab">
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
                <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Booking Request and Approval</h3>
                <div class="booking-table-container">
                    <div class="booking-thead-container">
                        <table class="booking-table-thead">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Student ID No</th>
                                    <th>Student Name</th>
                                    <th>Purpose</th>
                                    <th>Lab Room</th>
                                    <th>PC No</th>
                                    <th>Requested Time-In</th>
                                    <th>Request Created on</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="booking-tbody-container">
                        <table class="booking-table-tbody">
                            <tbody>
                                <?php
                                    $sql = "SELECT booking.*, student.s_idno, student.s_name 
                                            FROM booking 
                                            JOIN student ON booking.s_id = student.s_id";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $row['b_id'] . '</td>';
                                            echo '<td>' . $row['s_idno'] . '</td>';
                                            echo '<td>' . $row['s_name'] . '</td>';
                                            echo '<td>' . $row['b_purpose'] . '</td>';
                                            echo '<td>' . $row['b_labroom'] . '</td>';
                                            echo '<td>' . $row['b_pcno'] . '</td>';
                                            echo '<td>' . $row['b_time_in'] . '</td>';
                                            echo '<td>' . $row['b_request_dt'] . '</td>';
                                            echo '<td>';

                                            // Check if b_status is null
                                            if (is_null($row['b_status'])) {
                                                echo '<div class="bt-container-01">';
                                                echo '<button class="btn-accept" onclick="acceptBooking(' . $row['b_id'] . ')">Accept</button>';
                                                echo '<button class="btn-deny" onclick="denyBooking(' . $row['b_id'] . ')">Deny</button>';
                                                echo '</div>';
                                            } else {
                                                echo '' . $row['b_status'];
                                            }

                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="8">No booking requests found.</td></tr>';
                                    }
                                ?>

                            </tbody>
                        </table>
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
    function acceptBooking(bookingId) {
        if (confirm("Are you sure you want to accept this booking?")) {
            $.ajax({
                url: 'php/accept_booking.php',
                method: 'POST',
                data: { bookingId: bookingId },
                success: function(response) {
                    alert(response); 
                },
                error: function(xhr, status, error) {
                    console.error('Error accepting booking:', error);
                    alert('Error accepting booking. Please try again.');
                }
            });
        }
    }

    function denyBooking(bookingId) {
        if (confirm("Are you sure you want to deny this booking?")) {
            $.ajax({
                url: 'php/deny_booking.php',
                method: 'POST',
                data: { bookingId: bookingId },
                success: function(response) {
                    alert(response); 
                },
                error: function(xhr, status, error) {
                    console.error('Error denying booking:', error);
                    alert('Error denying booking. Please try again.');
                }
            });
        }
    }
</script>


</body>
</html>