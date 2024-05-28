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
                    <li class="current-tab">
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
                <div id="reports" class="content-section">
                    <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Generate Reports</h3>
                    <div class="main-body">
                        <h1 style="font-size:18px;">Search Transactions</h1>      
                        <div class="search_bar" style="justify-content: center;">
                            <input type="search" id="searchRecord" placeholder="Search Student ID here..." onkeyup="filterTable()">
                            <input type="date" id="searchDate" onchange="filterTable()">
                        </div>
                        
                        <div class="profile-edit">
                            <?php
                                $searchRecord = isset($_POST['searchRecord']) ? mysqli_real_escape_string($conn, $_POST['searchRecord']) : '';
                                
                                $sql = "SELECT records.*, student.s_name, student.s_course, student.session 
                                        FROM records 
                                        JOIN student ON records.s_idno = student.s_idno
                                        WHERE records.time_out IS NOT NULL";
                                
                                if (!empty($searchRecord)) {
                                    $sql .= " AND (records.s_idno LIKE '%$searchRecord%' OR 
                                                student.s_name LIKE '%$searchRecord%' OR 
                                                student.s_course LIKE '%$searchRecord%' OR 
                                                records.r_purpose LIKE '%$searchRecord%' OR 
                                                records.r_labroom LIKE '%$searchRecord%' OR 
                                                records.time_in LIKE '%$searchRecord%' OR 
                                                records.time_out LIKE '%$searchRecord%')";
                                }
                                
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $studentIds = array();
                                    $purposes = array();
                                    $labRooms = array();
                                    while ($row = $result->fetch_assoc()) {
                                        $studentId = $row["s_idno"];
                                        $purpose = $row["r_purpose"];
                                        $labRoom = $row["r_labroom"];
                                        if (!in_array($studentId, $studentIds)) {
                                            $studentIds[] = $studentId;
                                        }
                                        if (!in_array($purpose, $purposes)) {
                                            $purposes[] = $purpose;
                                        }
                                        if (!in_array($labRoom, $labRooms)) {
                                            $labRooms[] = $labRoom;
                                        }
                                    }
                                    
                                    echo '<table class="records-header">';
                                    echo '<tr>';
                                    echo '<th><select id="filterStudentId" onchange="filterTable(this.value)"><option value="">Student ID</option>';
                                    foreach ($studentIds as $studentId) {
                                        echo '<option value="' . $studentId . '">' . $studentId . '</option>';
                                    }
                                    echo '</select></th>';

                                    echo '<th>Name</th>';
                                    echo '<th>Course</th>';
                                    echo '<th>Session Left</th>';
                                    echo '<th><select id="filterPurpose" onchange="filterTable(this.value)"><option value="">Purpose</option>';
                                    foreach ($purposes as $purpose) {
                                        echo '<option value="' . $purpose . '">' . $purpose . '</option>';
                                    }
                                    echo '</select></th>';

                                    echo '<th><select id="filterLabRoom" onchange="filterTable(this.value)"><option value="">Lab Room</option>';
                                    foreach ($labRooms as $labRoom) {
                                        echo '<option value="' . $labRoom . '">' . $labRoom . '</option>';
                                    }
                                    echo '</select></th>';

                                    echo '<th>Time In</th>';
                                    echo '<th>Time Out</th>';
                                    echo '</tr>';
                                    echo '</table>';
                                    
                                    echo '<div class="filtered-records-tbody">';
                                    echo '<table class="records-table" id="recordsTable">';
                                    $result->data_seek(0);
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["s_idno"] . '</td>';
                                        echo '<td>' . $row["s_name"] . '</td>';
                                        echo '<td>' . $row["s_course"] . '</td>';
                                        echo '<td>' . $row["session"] . '</td>';
                                        echo '<td>' . $row["r_purpose"] . '</td>';
                                        echo '<td>' . $row["r_labroom"] . '</td>';
                                        echo '<td>' . $row["time_in"] . '</td>';
                                        echo '<td>' . $row["time_out"] . '</td>';
                                        echo '</tr>';
                                    }
                                    echo '</table>';
                                    echo '</div>';
                                } else {
                                    echo "No records found.";
                                }
                            ?>
                        </div>
                        <button onclick="exportToExcel()">Export to Excel</button>
                        <h1 style="font-size:18px;">Data Analytics</h1>      
                        <div id="analyticsSection" class="analytics-charts">
                            <div class="chart-container">
                                <canvas id="chart1"></canvas>
                            </div>
                            <div class="chart-container">
                                <canvas id="chart2"></canvas>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function filterTable() {
        var filterStudentId = document.getElementById("filterStudentId").value;
        var filterPurpose = document.getElementById("filterPurpose").value;
        var filterLabRoom = document.getElementById("filterLabRoom").value;
        var searchRecord = document.getElementById("searchRecord").value.toUpperCase(); 
        var searchDate = document.getElementById("searchDate").value;
        var rows = document.querySelectorAll(".records-table tr");

        rows.forEach(function(row) {
            var studentId = row.cells[0].textContent;
            var purpose = row.cells[4].textContent;
            var labRoom = row.cells[5].textContent;
            var timeIn = row.cells[6].textContent;

            var hideRow = false;
            if (searchRecord && studentId.toUpperCase().indexOf(searchRecord) === -1) {
                hideRow = true;
            }
            if (filterStudentId && studentId !== filterStudentId) {
                hideRow = true;
            }
            if (filterPurpose && purpose !== filterPurpose) {
                hideRow = true;
            }
            if (filterLabRoom && labRoom !== filterLabRoom) {
                hideRow = true;
            }
            if (searchDate && timeIn.indexOf(searchDate) === -1) {
                hideRow = true;
            }

            if (hideRow) {
                row.style.display = "none";
            } else {
                row.style.display = "";
            }
        });
    }

    function exportToExcel() {
        var table = document.getElementById('recordsTable');
        
        var wb = XLSX.utils.book_new();
        
        var ws = XLSX.utils.table_to_sheet(table);
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        
        var fileName = 'filtered_records.xlsx';
        
        XLSX.writeFile(wb, fileName);
    }
    
    function generateBarCharts(data1, labels1, data2, labels2) {
        var colors = ['#734db9', '#965fc7', '#b36fdb', '#d288ff', '#e6a8ff', '#f4c7ff', '#fedbff', '#f7e3ff', '#fbf0ff', '#fcecff', '#fdf9ff'];

        var ctx1 = document.getElementById('chart1').getContext('2d');
        var ctx2 = document.getElementById('chart2').getContext('2d');

        var chart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels1,
                datasets: [{
                    label: 'Number of Sit-Ins by Purpose',
                    data: data1,
                    backgroundColor: colors.slice(0, data1.length),
                    borderColor: '#734db9',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var chart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'Number of Sit-Ins by Laboratory Room',
                    data: data2,
                    backgroundColor: colors.slice(0, data2.length),
                    borderColor: '#734db9',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function fetchAndRenderCharts() {
        $.ajax({
            url: 'php/fetch_analytics_data.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var purposesData = response.purposesData;
                var purposesLabels = response.purposesLabels;
                var labRoomsData = response.labRoomsData;
                var labRoomsLabels = response.labRoomsLabels;

                generateBarCharts(purposesData, purposesLabels, labRoomsData, labRoomsLabels);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching analytics data:', error);
                console.log(xhr.responseText); 
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var ctx1 = document.getElementById('chart1').getContext('2d');
        var ctx2 = document.getElementById('chart2').getContext('2d');

        generateBarCharts(purposesData, purposesLabels, labRoomsData, labRoomsLabels);
    });

    $(document).ready(function() {
        fetchAndRenderCharts();
    });

</script>


</body>
</html>