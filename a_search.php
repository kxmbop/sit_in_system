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
                    <li class="current-tab">
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
                <div id="search" class="content-section">
                    <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Search Student</h3>
                    <section class="main">
                        <div class="main-body">
                            <h1>Look up for student and book!</h1>        
                            <div class="search_bar">
                                <input type="search" id="searchInput" placeholder="Search student here...">
                                <button onclick="searchAndShowDetails()">Search</button>
                            </div>
                            <div id="studentDetailsArea" class="student-details-content">
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
                                    <h4 style="margin: 0 auto; text-align:center;">~~~~~~~~~~~ Book Sit-in ~~~~~~~~~~~</h4>
                                </div>
                                <div class="detail-row">
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
                                        <option value="Go">Go</option>
                                    </select>
                                </div>
                                <div class="detail-row">
                                    <label for="labRoom">Lab Room:</label>
                                    <select id="labRoom" name="labRoom" required>
                                        <option value="">Select Lab Room</option>
                                        <option value="524">524</option>
                                        <option value="526">526</option>
                                        <option value="528">528</option>
                                        <option value="529">529</option>
                                        <option value="542">542</option>
                                        <option value="544">544</option>
                                    </select>
                                </div>
                                <button onclick="bookSitIn()">Book Sit-in</button>
                                <div id="recordsTableArea" class="recordsTableArea">
                                    <h2 style="text-align: center; margin-bottom: 10px;">Student Records</h2>
                                    <table id="recordsTable" class="table">
                                        <table class="recordsTableHead">
                                            <thead>
                                                <tr>
                                                    <th>Purpose</th>
                                                    <th>Lab Room</th>
                                                    <th>Time In</th>
                                                    <th>Time Out</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="recordsTableBodyWrapper">
                                            <table class="recordsTableBody">
                                                <tbody id="recordsTableBody">
                                                    <!-- Records will be populated dynamically -->
                                                </tbody>
                                            </table>
                                        </div> 
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
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

        function searchAndShowDetails(searchedId = null) {
            const searchTerm = searchedId || document.getElementById('searchInput').value.trim();

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

                        fetchAndDisplayRecords(response.s_idno);
                        sessionStorage.setItem('searchedStudentId', response.s_idno);
                    } else {
                        $('#studentDetailsArea').html('<p>Student not found.</p>');
                        $('#bookSitInButton').prop('disabled', true);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    console.log('Server Response:', jqXHR.responseText);
                    alert('Error fetching student details. Please try again.');
                }
            });
        }

        function fetchAndDisplayRecords(studentId) {
            $.ajax({
                type: 'POST',
                url: 'php/fetch_records.php',
                data: { studentId: studentId },
                dataType: 'json',
                success: function(response) {
                    console.log('Response:', response);
                    if (response.success && response.records.length > 0) {
                        $('#recordsTableBody tbody').empty();

                        $.each(response.records, function(index, record) {
                            var row = '<tr>' +
                                '<td>' + record.r_purpose + '</td>' +
                                '<td>' + record.r_labroom + '</td>' +
                                '<td>' + record.time_in + '</td>' +
                                '<td>' + record.time_out + '</td>' +
                                '</tr>';
                            $('#recordsTableBody').append(row);
                        });

                        $('#recordsTableArea').show();
                    } else {
                        $('#recordsTableBody').html('<tr><td colspan="5">No records found for this student.</td></tr>');
                        $('#recordsTableArea').show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    alert('Error fetching records. Please try again.');
                }
            });
        }

        function bookSitIn() {
            var s_idno = document.getElementById('s_idno').innerText;
            var purpose = document.getElementById('purpose').value;
            var labRoom = document.getElementById('labRoom').value;

            if (!purpose || !labRoom) {
                alert('Please select both purpose and lab room.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: 'php/book_sit_in.php',
                data: {
                    s_idno: s_idno,
                    r_purpose: purpose,
                    r_labroom: labRoom
                },
                success: function(response) {
                    if (response.success) {
                        alert('Sit-in booked successfully!');
                        location.reload(true);
                    } else {
                        alert('Error booking sit-in: ' + response.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    alert('Error booking sit-in. Please try again.');
                },
                dataType: 'json'
            });
        }

    </script>

</body>
</html>