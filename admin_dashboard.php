<?php
session_start();
include('database.php');

if (isset($_POST['r_id'])) {
    $r_id = $_POST['r_id']; 

    $sql = "UPDATE records SET time_out = current_timestamp() WHERE r_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $r_id); 
    if ($stmt->execute()) {
        $updateSql = "UPDATE student SET session = session - 1 WHERE s_idno = (
            SELECT s_idno FROM records WHERE r_id = ?
        )";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('i', $r_id);
        
        if ($updateStmt->execute()) {
            echo "Time out recorded successfully for record ID " . $r_id;
        } else {
            echo "Error updating student session count: " . $conn->error;
        }
    } else {
        echo "Error occurred while recording time out: " . $stmt->error;
    }
    $stmt->close();
    exit;
}
/*
if (isset($_POST['studentId'])) {
    $studentId = mysqli_real_escape_string($conn, $_POST['studentId']);

    $sql = "SELECT records.s_idno, records.r_purpose, records.r_labroom, records.time_in, records.time_out, 
                   student.s_name, student.s_course, student.session 
            FROM records 
            JOIN student ON records.s_idno = student.s_idno
            WHERE records.s_idno = '$studentId'";
    $result = $conn->query($sql);

    $response = array();

    if ($result->num_rows > 0) {
        $records = array();
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        $response['records'] = $records;
    } else {
        $response['records'] = array();
    }


    echo json_encode($response) . "\n";
} else {
    echo json_encode(array('error' => 'Student ID not provided')) . "\n";
}
*/

if (isset($_POST['studentId'], $_POST['purpose'], $_POST['labRoom'])) {
    $studentId = $_POST['studentId'];
    $purpose = $_POST['purpose'];
    $labRoom = $_POST['labRoom'];

    $reservationSql = "INSERT INTO records (s_idno, r_purpose, r_labroom) 
        VALUES (?, ?, ?)";
    $reservationStmt = $conn->prepare($reservationSql);
    $reservationStmt->bind_param('sss', $studentId, $purpose, $labRoom);

    if ($reservationStmt->execute()) {
        echo "Record added successfully";
    } else {
        echo "Error adding record: " . $conn->error;
    }

    $reservationStmt->close();

    exit;
}


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
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style/style01.css" />
    
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
                <ul>
                    <li>
                        <a href="#" onclick="showContent('search', this)">
                            <i class="fas fa-search"></i>
                            <span class="nav-item">Search</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="showContent('delete', this)">
                            <i class="fas fa-trash-alt"></i>
                            <span class="nav-item">Delete</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="showContent('sit-in', this)">
                            <i class="fas fa-address-book"></i>
                            <span class="nav-item">View Sit-In Records</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="showContent('reports', this)">
                            <i class="far fa-file-excel"></i>
                            <span class="nav-item">Generate Reports</span>
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
                <!-- Search -->
                <div id="search" class="content-section">
                    <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Search Transaction</h3>
                    <section class="main">
                        <div class="main-body">
                            <h1>Recent Transactions</h1>        
                            <div class="search_bar">
                                <input type="search" id="searchInput" placeholder="Search student here...">
                                <button onclick="searchAndShowModal()">Search</button>
                            </div>
                            <div class="row">
                                <p>There are more than <span>400</span> transactions</p>
                                <a href="#">See all</a>
                            </div>

                            <!-- Student Cards -->
                            <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="job_card">';
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
                                        echo '<i class="fas fa-edit" onclick="showStudentDetailsModal(' . $row["s_idno"] . ')"></i>';
                                        echo '<i class="fas fa-trash-alt"></i>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "No student records found.";
                                }
                            ?>
                        </div>
                    </section>
                </div>
                <!-- ~~~~~~~~~~~~~~~~~~~~ Delete ~~~~~~~~~~~~~~~~~~~~ -->                
                <div id="delete" class="content-section">
                    <div class="main-body">
                        <h3 style="font-size: 28px; font-weight: bold; text-align: left;">Delete</h3>
                        <div class="profile-edit">
                        </div>
                    </div>
                </div>
                <!-- ~~~~~~~~~~~~~~~~~~~~ View Sit-In Records ~~~~~~~~~~~~~~~~~~~~ -->
                <div id="sit-in" class="content-section">
                    <h3 style="font-size: 28px; font-weight: bold; text-align: left;">View Sit-In Records</h3>
                    <div class="main-body">
                        <div class="profile-edit">
                            <?php
                                $sql = "SELECT records.*, student.s_name, student.s_course, student.session 
                                        FROM records 
                                        JOIN student ON records.s_idno = student.s_idno";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo '<table class="records-header">';
                                    echo '<tr><th>Student ID</th><th>Name</th><th>Course</th><th>Session Left</th><th>Purpose</th><th>Lab Room</th><th>Time In</th><th>Action</th></tr>';
                                    echo '</table>';
                                    echo '<table class="records-table">';
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row["time_out"] === null) {
                                            echo '<tr>';
                                            echo '<td>' . $row["s_idno"] . '</td>';
                                            echo '<td>' . $row["s_name"] . '</td>';
                                            echo '<td>' . $row["s_course"] . '</td>';
                                            echo '<td>' . $row["session"] . '</td>';
                                            echo '<td>' . $row["r_purpose"] . '</td>';
                                            echo '<td>' . $row["r_labroom"] . '</td>';
                                            echo '<td>' . $row["time_in"] . '</td>';
                                            echo '<td><i class="fas fa-hourglass-end action-icon" onclick="timeout(' . $row["r_id"] . ')"></i></td>';
                                            echo '</tr>';
                                        }
                                    }
                                    echo '</table>';
                                } else {
                                    echo "No records found.";
                                }
                            ?>
                        </div>
                    </div>    
                </div>
                <!-- ~~~~~~~~~~~~~~~~~~~~ Generate Reports ~~~~~~~~~~~~~~~~~~~~ -->
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
                                } else {
                                    echo "No records found.";
                                }
                            ?>
                        </div>
                        <button onclick="exportToExcel()">Export to Excel</button>
                    </div>    
                </div>
            </div>
        </section>
    </div>

    <div id="studentDetailsModal" class="modal">
        <div class="modal-content">
                <span class="close" onclick="closeStudentDetailsModal()">&times;</span>
                <h2>Student Details</h2>
                <div id="studentDetailsContent" class="student-details"></div>            
        </div>
    </div>

    <div class="modal fade" id="searchResultModal" tabindex="-1" aria-labelledby="searchResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    
                </div>
                <div class="modal-body" id="searchResultBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>


    <script>

    function showStudentDetailsModal(studentId) {
        jQuery.ajax({
            url: 'admin_dashboard.php',
            method: 'POST',
            data: { studentId: studentId },
            dataType: 'json',
            success: function(response) {
                var modalContent = `
                    <br>
                    <div class="detail-row">
                        <label>ID No: </label><p>${response.s_idno}</p>
                    </div>
                    <div class="detail-row">
                        <label>Name: </label><p>${response.s_name}</p>
                    </div>
                    <div class="detail-row">
                        <label>Email: </label><p>${response.s_email}</p>
                    </div>
                    <div class="detail-row">
                        <label>Course: </label><p>${response.s_course}</p>
                    </div>
                    <div class="detail-row">
                        <label>Age: </label><p>${response.s_age}</p>
                    </div>
                    <div class="detail-row">
                        <label>Address: </label><p>${response.s_address}</p>
                    </div>
                    <div class="detail-row">
                        <label>Gender: </label><p>${response.s_gender}</p>
                    </div>
                    <div class="detail-row">
                        <label>Remaining Session: </label><p>${response.session}</p>
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
                    <button onclick="bookSitIn('${response.s_idno}')">Book Sit-in</button>
                `;
                jQuery('#studentDetailsContent').html(modalContent);  
                jQuery('#studentDetailsModal').css('display', 'block');
            },
            error: function(xhr, status, error) {
                alert('Error fetching student details. Please try again later.');
                console.error(xhr.responseText);
            }
        });
    }

    function closeStudentDetailsModal() {
        jQuery('#studentDetailsModal').css('display', 'none');
    }

    function bookSitIn(studentId) {
        var purpose = document.getElementById('purpose').value;
        var labRoom = document.getElementById('labRoom').value;
        
        jQuery.ajax({
            url: 'admin_dashboard.php',
            method: 'POST',
            data: { studentId: studentId, purpose: purpose, labRoom: labRoom },
            success: function(response) {
                alert('Sit-in successfully booked!');
                closeStudentDetailsModal(); 
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Error booking sit-in. Please try again later.');
                console.error(xhr.responseText);
            }
        });
    }

    function timeout(r_id) {
        $.ajax({
            url: 'admin_dashboard.php', 
            method: 'POST',
            data: { r_id: r_id },
            success: function(response) {
                alert('Time out recorded successfully for record ID ' + r_id);
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Error occurred while recording time out. Please try again later.');
                console.error(xhr.responseText);
            }
        });
    }

    function searchAndShowModal() {
        var studentId = document.getElementById('searchInput').value;
        showStudentDetailsModal(studentId);
    }

    document.addEventListener("DOMContentLoaded", function() {
        showContent('search');
    });

    function showContent(sectionId) {
        var contentSections = document.querySelectorAll('.content-section');
        contentSections.forEach(function(section) {
            section.style.display = 'none';
        });
        document.getElementById(sectionId).style.display = 'block';
        
        var icons = document.querySelectorAll('.icon');
        icons.forEach(function(icon) {
            icon.classList.remove('clicked');
        });

        document.getElementById(sectionId + '-icon').classList.add('clicked');
    }

    function filterTable() {
        var filterStudentId = document.getElementById("filterStudentId").value;
        var filterPurpose = document.getElementById("filterPurpose").value;
        var filterLabRoom = document.getElementById("filterLabRoom").value;
        var searchRecord = document.getElementById("searchRecord").value.toUpperCase(); // Get search input
        var searchDate = document.getElementById("searchDate").value;
        var rows = document.querySelectorAll(".records-table tr");

        rows.forEach(function(row) {
            var studentId = row.cells[0].textContent;
            var purpose = row.cells[4].textContent;
            var labRoom = row.cells[5].textContent;
            var timeIn = row.cells[6].textContent;

            var hideRow = false;
            // Check if the row matches the search query
            if (searchRecord && studentId.toUpperCase().indexOf(searchRecord) === -1) {
                hideRow = true;
            }
            // Check if the row matches the dropdown filters
            if (filterStudentId && studentId !== filterStudentId) {
                hideRow = true;
            }
            if (filterPurpose && purpose !== filterPurpose) {
                hideRow = true;
            }
            if (filterLabRoom && labRoom !== filterLabRoom) {
                hideRow = true;
            }
            // Check if the row matches the selected date
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
    /*
    function getStudentDetails(searchRecord) {
        var studentId = searchRecord.trim();

            if (studentId !== "") {
                $.ajax({
                    url: 'admin_dashboard.php',
                    type: 'POST',
                    data: { studentId: studentId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            $('#searchResultBody').html('<p>' + response.error + '</p>');
                            $('#searchResultModal').modal('show');
                        } else {
                            if (response.records && response.records.length > 0) {
                                var html = '<table class="modal-records-header">';
                                html += '<tr><th>Student ID</th><th>Name</th><th>Course</th><th>Session Left</th><th>Purpose</th><th>Lab Room</th><th>Time In</th><th>Time Out</th></tr>';
                                html += '</table>';
                                html += '<table class="modal-records-table">';
                                for (var j = 0; j < response.records.length; j++) {
                                    var record = response.records[j];
                                    html += '<tr>';
                                    html += '<td>' + record.s_idno + '</td>';
                                    html += '<td>' + record.s_name + '</td>';
                                    html += '<td>' + record.s_course + '</td>';
                                    html += '<td>' + record.session + '</td>';
                                    html += '<td>' + record.r_purpose + '</td>';
                                    html += '<td>' + record.r_labroom + '</td>';
                                    html += '<td>' + record.time_in + '</td>';
                                    html += '<td>' + record.time_out + '</td>';
                                    html += '</tr>';
                                }
                                html += '</table>';
                                $('#searchResultBody').html(html);
                                $('#searchResultModal').modal('show');
                            } else {
                                $('#searchResultBody').html('<p>No records found for student ID ' + studentId + '</p>');
                                $('#searchResultModal').modal('show');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                alert("Please enter a Student ID.");
            }
    }
    */

    function exportToExcel() {
        var table = document.getElementById('recordsTable');
        
        var wb = XLSX.utils.book_new();
        
        var ws = XLSX.utils.table_to_sheet(table);
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        
        var fileName = 'filtered_records.xlsx';
        
        XLSX.writeFile(wb, fileName);
    }
</script>


</body>
</html>