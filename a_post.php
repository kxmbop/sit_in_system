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
                    <!--<li class="inactive-tab">
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
                    <li class="current-tab">
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
                <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Post Announcement</h3>
                <div class="post-announcements">
                    <span>Type announcement here: </span>
                    <div class="pa-title">
                        <label>Title: </label>
                        <input type="text" id="announcementTitle">
                    </div>
                    <div class="pa-message">
                        <label>Message:</label>
                        <textarea id="announcementMessage"></textarea>
                    </div>
                    <button onclick="postAnnouncement()">Post</button>
                </div>
                <div class="announcement-container">
                    <div class="posted-announcments">
                        <?php include('php/fetch_announcements.php'); ?>
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
    function postAnnouncement() {
        var title = document.getElementById('announcementTitle').value;
        var message = document.getElementById('announcementMessage').value;

        $.ajax({
            url: 'php/post_announcement.php',
            method: 'POST',
            data: { title: title, message: message },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Announcement posted successfully!');
                    location.reload(true);
                } else {
                    alert('Failed to post announcement: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error posting announcement:', error);
            }
        });
    }

    $(document).ready(function() {
        $('.close-btn').click(function() {
            var card = $(this).closest('.announcement-card');
            var announcementId = card.data('announcement-id');

            $.ajax({
                url: 'php/delete_announcement.php',
                method: 'POST',
                data: { announcement_id: announcementId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        card.fadeOut(300, function() {
                            $(this).remove();
                        });
                        alert(response.message); 
                    } else {
                        alert('Failed to delete announcement: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting announcement:', error);
                }
            });
        });
    });

</script>


</body>
</html>