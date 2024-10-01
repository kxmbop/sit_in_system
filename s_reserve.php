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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                    <li class="current-tab">
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
                <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Future Reservations</h3>
                <div class="reserve-container">
                    <form id="reservationForm">
                        <label style="margin: 0 0 30px 0;">Submit Reservation here for future dates!</label>
                        <input type="hidden" id="studentId" name="studentId" value="<?php echo $user_id; ?>">

                        <div class="form-group">
                            <label for="purpose">Purpose:</label>
                            <select id="purpose" name="purpose" required>
                                <option value="">Select Purpose</option>
                                <option value="Java">Java</option>
                                <option value="Python">Python</option>
                                <option value="JavaScript">JavaScript</option>
                                <option value="C++">C++</option>
                                <option value="C#">C#</option>
                                <option value="PHP">PHP</option>
                                <option value="Ruby">Ruby</option>
                                <option value="Swift">Swift</option>
                                <option value="Kotlin">Kotlin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="labroom">Lab Room:</label>
                            <select id="labroom" name="labroom" required>
                                <option value="">Select Lab Room</option>
                                <option value="524">524</option>
                                <option value="526">526</option>
                                <option value="528">528</option>
                                <option value="529">529</option>
                                <option value="542">542</option>
                                <option value="544">544</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pcno">PC number:</label>
                            <select id="pcno" name="pcno" required>
                                <option value="">Select PC number</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="timeIn">Requested Time In:</label>
                            <input type="datetime-local" id="timeIn" name="timeIn" required>
                        </div>

                        <button type="button" onclick="submitReservation()">Reserve</button>
                    </form>
                </div>
                <div class="student-booking">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID No</th>
                            <th>Student Name</th>
                            <th>Purpose</th>
                            <th>Lab Room</th>
                            <th>Requested Time-In</th>
                            <th>Request Created on</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        include('database.php');

                        $sql = "SELECT booking.*, student.s_idno, student.s_name 
                                FROM booking 
                                JOIN student ON booking.s_id = student.s_id 
                                WHERE student.s_id = '$user_id' 
                                ORDER BY booking.b_request_dt DESC";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {


                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['s_idno'] . '</td>';
                                echo '<td>' . $row['s_name'] . '</td>';
                                echo '<td>' . $row['b_purpose'] . '</td>';
                                echo '<td>' . $row['b_labroom'] . '</td>';
                                echo '<td>' . $row['b_time_in'] . '</td>';
                                echo '<td>' . $row['b_request_dt'] . '</td>';
                                echo '<td>';

                                if (is_null($row['b_status'])) {
                                    echo '<span class="status-pending">Pending</span>';
                                } else if ($row['b_status'] == 'accepted') {
                                    echo '<span class="status-accepted">Accepted</span>';
                                } else if ($row['b_status'] == 'denied') {
                                    echo '<span class="status-denied">Denied</span>';
                                }

                                echo '</td>';
                                echo '</tr>';
                            }

                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<p>No booking requests found.</p>';
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
                </div>
            </div>
        </section>



    </div>

</body>
<script>
    function submitReservation() {
        var formData = new FormData(document.getElementById('reservationForm'));
        var timeIn = new Date(formData.get('timeIn'));

        if (timeIn <= new Date()) {
            alert('Please select a future date and time for "Requested Time In".');
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'php/submit_reservation.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response); 
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error submitting reservation:', error);
                alert('Error submitting reservation. Please try again.'); 
            }
        });
    }

</script>
</html>



