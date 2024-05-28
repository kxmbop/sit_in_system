<?php
session_start();

include("database.php");

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_idno = $_SESSION['user_idno'];
    $user_name = $_SESSION['user_name'];
    $user_course = $_SESSION['user_course'];
    $user_email = $_SESSION['user_email'];
    $user_age = $_SESSION['user_age'];
    $user_address = $_SESSION['user_address'];
    $user_gender = $_SESSION['user_gender'];
    $user_pass = $_SESSION['user_pass'];
    
} else {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="style/style.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-xr5pF7zZ9aiENRGA3sSFLji/Sp9/Z5OuPck+mXSvzg45SoLLQFtyh2kjTYJePgzrA/Gy9+NQ+74CjMlUIz6P8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body onload="showContent('dashboard')">
    <div class="container">
        <nav>
            <div class="navbar">
                <div class="logo">
                    <h1><?php echo $user_name ?? 'undefined'; ?>!</h1>
                </div>
                <ul class="nav-class">
                    <li class="inactive-tab">
                        <a href="s_dashboard.php">
                            <i class="fas fa-chart-bar"></i>
                            <span class="nav-item">Dashboard</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                        <a href="s_edit_profile.php">
                            <i class="fas fa-user "></i>
                            <span class="nav-item">Edit Profile</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                        <a href="s_view_sessions.php" >
                            <i class="fas fa-address-book"></i>
                            <span class="nav-item">View Sessions</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                        <a href="s_feedback.php">
                        <i class="fas fa-comment"></i>
                            <span class="nav-item">Feedback & Reporting</span>
                        </a>
                    </li>
                    <li class="current-tab">
                        <a href="s_monitoring.php">
                            <i class="fas fa-exclamation-circle"></i>
                            <span class="nav-item">Safety Monitoring</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                        <a href="s_announcements.php">
                            <i class="fas fa-bullhorn"></i>
                            <span class="nav-item">View Announcement</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                        <a href="s_reserve.php">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="nav-item">Future Reservations</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                        <a href="s_lab_rules.php">
                            <i class="fas fa-book"></i>
                            <span class="nav-item">Lab Sit-in Rules</span>
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
                <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Safety Monitoring/Alert</h3>

            </div>
        </section>

    </div>

</body>
<script>


</script>
</html>



