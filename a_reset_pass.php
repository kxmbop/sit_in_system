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
                    <li class="current-tab">
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
                <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Reset Password</h3>
                    <br>
                    <div class="search_bar">
                        <input type="search" id="searchInput" placeholder="Search student ID here...">
                        <button onclick="searchAndShowDetails()">Search</button>
                    </div>
                <div class="delete-profile">
                    <div class="student-details-section"> 
                        <div id="studentDetailsArea">
                            <h2 style="text-align: center;">Student Details</h2>
                            <br>
                            <div class="detail-row">
                                <label>ID No: </label><p id="s_idno"></p>
                            </div>
                            <div class="detail-row">
                                <label>Name: </label><p id="s_name"></p>
                            </div>
                            <div class="detail-row">
                                <label>Email: </label><p id="s_email"></p>
                            </div>
                            <div class="detail-row">
                                <label>Course: </label><p id="s_course"></p>
                            </div>
                            <div class="detail-row">
                                <label>Age: </label><p id="s_age"></p>
                            </div>
                            <div class="detail-row">
                                <label>Address: </label><p id="s_address"></p>
                            </div>
                            <div class="detail-row">
                                <label>Gender: </label><p id="s_gender"></p>
                            </div>
                            <div class="detail-row">
                                <label>Remaining Session: </label><p id="session"></p>
                            </div>
                            <div class="detail-row">
                                <h4 style="margin: 0 auto; text-align:center;">~~~~~~~~~~~ Reset Password ~~~~~~~~~~~</h4>
                            </div>
                            <div class="detail-row-pass">
                                <label for="newPassword">New password:</label>
                                <input type="password" id="newPassword">
                            </div>
                            <div class="detail-row-pass">
                                <label for="confirmPassword">Confirm password:</label>
                                <input type="password" id="confirmPassword">
                            </div>
                            <button onclick="resetPass()">Reset</button>
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
        function searchAndShowDetails() {
            var searchTerm = document.getElementById('searchInput').value.trim();

            if (searchTerm === '') {
                alert('Please enter a search term.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: 'php/search_students.php',
                data: { searchTerm: searchTerm },
                dataType: 'json',
                success: function(response) {
                    console.log('Response:', response);
                    if (response.success) {
                        $('#s_idno').text(response.s_idno);
                        $('#s_name').text(response.s_name);
                        $('#s_email').text(response.s_email);
                        $('#s_course').text(response.s_course);
                        $('#s_age').text(response.s_age);
                        $('#s_address').text(response.s_address);
                        $('#s_gender').text(response.s_gender);
                        $('#session').text(response.session);
                    } else {
                        $('#studentDetailsArea').html('<p>Student not found.</p>');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    console.log('Server Response:', jqXHR.responseText);
                    alert('Error fetching student details. Please try again.');
                }
            });
        }

        function resetPass() {
            var newPassword = document.getElementById('newPassword').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            var s_idno = document.getElementById('s_idno').innerText;

            if (newPassword === '' || confirmPassword === '') {
                alert('Please enter both password fields.');
                return;
            }

            if (newPassword !== confirmPassword) {
                alert('Passwords do not match.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: 'php/reset_password.php',
                data: {
                    s_idno: s_idno,
                    newPassword: newPassword
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Password reset successfully!');
                    } else {
                        alert('Error resetting password: ' + response.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    alert('Error resetting password. Please try again.');
                }
            });
        }
    </script>

</body>
</html>
