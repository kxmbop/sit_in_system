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

$sql = "SELECT * FROM student";
$result = $conn->query($sql);

if (isset($_POST['studentId'])) {
    $studentId = $_POST['studentId'];

    $sql = "SELECT * FROM student WHERE s_idno = $studentId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $studentDetails = $result->fetch_assoc();

        echo json_encode($studentDetails);
    } else {
        echo json_encode(array());
    }
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
                    <li class="current-tab">
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
                    <li class="inactive-tab">
                    <a href="a_reset_session.php">
                            <i class="fa-solid fa-arrows-rotate"></i>
                            <span class="nav-item">Reset Session</span>
                        </a>
                    </li>
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
                <div class="content-section">
                    <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Delete</h3>
                    <div class="delete-profile">
                        <h2>Search student:</h2>
                        <br>
                        <input id="searchInput" placeholder="Search student name here...">
                        <div class="student-cards"> 
                            <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="job_card" data-name="' . strtolower($row["s_name"]) . '">';
                                        echo '<div class="job_details">';
                                        echo '<div class="img">';
                                        echo '<i class="far fa-user-circle"></i>';
                                        echo '</div>';
                                        echo '<div class="text">';
                                        echo '<h2>' . $row["s_name"] . '</h2>';
                                        echo '<span>' . $row["s_idno"] . '</span>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '<div class="job_info">';
                                        echo '<h4>' . $row["s_course"] . '</h4>';
                                        echo '<span>Session Left: ' . $row["session"] . '</span>';
                                        echo '</div>';
                                        echo '<div class="job_icons">';
                                        echo '<i class="fas fa-trash-alt" onclick="deleteStudent(' . $row["s_idno"] . ')"></i>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "No student records found.";
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
    document.getElementById('searchInput').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        var studentCards = document.querySelectorAll('.student-cards .job_card');

        studentCards.forEach(function(card) {
            var name = card.getAttribute('data-name');
            if (name.includes(filter)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    function deleteStudent(s_idno) {
        if (confirm('Are you sure you want to delete this student?')) {
            $.ajax({
                type: 'POST',
                url: 'php/delete_student.php',
                data: { s_idno: s_idno },
                success: function(response) {
                    if (response.success) {
                        alert('Student deleted successfully!');
                        location.reload(); 
                    } else {
                        alert('Error deleting student: ' + response.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    alert('Error deleting student. Please try again.');
                },
                dataType: 'json'
            });
        }
    }
</script>


</body>
</html>