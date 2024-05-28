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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $course = $_POST['course'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    $sql = "UPDATE student SET s_name=?, s_course=?, s_email=?, s_age=?, s_address=?, s_gender=?, s_pass=? WHERE s_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssi', $name, $course, $email, $age, $address, $gender, $password, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_course'] = $course;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_age'] = $age;
        $_SESSION['user_address'] = $address;
        $_SESSION['user_gender'] = $gender;
        $_SESSION['user_pass'] = $password;

        header("Location: s_edit_profile.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
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
                    <li class="current-tab">
                        <a href="s_edit_profile.php">
                            <i class="fas fa-user "></i>
                            <span class="nav-item">Edit Profile</span>
                        </a>
                    </li>
                    <li class="inactive-tab">
                        <a href="s_view_sessions.php">
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
                <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Edit Profile</h3>
                <div id="edit-profile" class="content-section">
                    <div class="profile-edit">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="edit-form">
                            <br>
                            <div class="center-content">
                                <label for="student_id">Student ID:</label>
                                <input type="text" id="student_id" name="student_id" value="<?php echo $user_idno; ?>" readonly> <br>
                                
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $user_name; ?>"><br>

                                <label for="course">Course:</label>
                                <input type="text" id="course" name="course" value="<?php echo isset($_POST['course']) ? $_POST['course'] : $user_course; ?>"><br>

                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : $user_email; ?>"><br>

                                <label for="age">Age:</label>
                                <input type="number" id="age" name="age" value="<?php echo isset($_POST['age']) ? $_POST['age'] : $user_age; ?>"><br>
                                
                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : $user_address; ?>"><br>

                                <label for="gender">Gender:</label>
                                <input type="text" id="gender" name="gender" value="<?php echo isset($_POST['gender']) ? $_POST['gender'] : $user_gender; ?>"><br>
                                
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : $user_pass; ?>"><br>

                                <button type="submit" class="form-control btn btn-primary submit px-3">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

</body>
<script>


</script>
</html>



