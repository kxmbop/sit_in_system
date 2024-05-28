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
                    <li class="inactive-tab">
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
                    <li class="current-tab">
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
                <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Lab Sit-in Rules</h3>
                <div class="rules-container">
                    <h2>University of Cebu</h2>
                    <h4>COLLEGE OF INFORMATION & COMPUTER STUDIES</h4>
                    <div class="rules">
                        <h3>LABORATORY RULES AND REGULATIONS</h3>
                        <p>To avoid embarrassment and maintain camaraderie with your friends and superiors at our laboratories, please observe the following:</p>
                        <div class="one-ten">
                            <p>1. Maintain silence, proper decorum, and discipline inside the laboratory. Mobile phones, walkmans and other personal pieces of equipment must be switched off.</p>
                            <p>2. Games are not allowed inside the lab. This includes computer-related games, card games and other games that may disturb the operation of the lab.</p>
                            <p>3. Surfing the Internet is allowed only with the permission of the instructor. Downloading and installing of software are strictly prohibited.</p>
                            <p>4. Getting access to other websites not related to the course (especially pornographic and illicit sites) is strictly prohibited.</p>
                            <p>5. Deleting computer files and changing the set-up of the computer is a major offense. </p>
                            <p>6. Observe computer time usage carefully. A fifteen-minute allowance is given for each use. Otherwise, the unit will be given to those who wish to "sit-in".</p>
                            <p>7. Observe proper decorum while inside the laboratory.</p>
                            <div class="a-e">
                                <p>a. Do not get inside the lab unless the instructor is present.</p>
                                <p>b. All bags, knapsacks, and the likes must be deposited at the counter.</p>
                                <p>c. Follow the seating arrangement of your instructor.</p>
                                <p>d. At the end of class, all software programs must be closed.</p>
                                <p>e. Return all chairs to their proper places after using.</p>
                            </div>
                            <p>8. Chewing gum, eating, drinking, smoking, and other forms of vandalism are prohibited inside the lab.</p>
                            <p>9. Anyone causing a continual disturbance will be asked to leave the lab. Acts or gestures offensive to the members of the community, including public display of physical intimacy, are not tolerated.</p>
                            <p>10. Persons exhibiting hostile or threatening behavior such as yelling, swearing, or disregarding requests made by lab personnel will be asked to leave the lab.</p>
                            <p>11. For serious offense, the lab personnel may call the Civil Security Office (CSU) for assistance.</p>
                            <p>12. Any technical problem or difficulty must be addressed to the laboratory supervisor, student assistant or instructor immediately.</p>
                        </div>
                        <h4>DISCIPLINARY ACTION</h4>
                        <div class="discipline">
                            <p>• First Offense - The Head or the Dean or OIC recommends to the Guidance Center for a suspension from classes for each offender.</p>
                            <p>• Second and Subsequent Offenses - A recommendation for a heavier sanction will be endorsed to the Guidance Center.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

</body>
<script>


</script>
</html>



