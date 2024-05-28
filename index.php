<?php
include("database.php");

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$error_message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['s_login'])) {
        $s_idno = sanitize_input($_POST['s_idno']);
        $s_pswd = sanitize_input($_POST['s_pswd']);

        $sql = "SELECT * FROM student WHERE s_idno = ? AND s_pass = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $s_idno, $s_pswd);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            session_start();
            $_SESSION['user_id'] = $row['s_id'];
            $_SESSION['user_idno'] = $row['s_idno'];
            $_SESSION['user_name'] = $row['s_name'];
            $_SESSION['user_course'] = $row['s_course'];
            $_SESSION['user_email'] = $row['s_email'];
            $_SESSION['user_age'] = $row['s_age'];
            $_SESSION['user_address'] = $row['s_address'];
            $_SESSION['user_gender'] = $row['s_gender'];
            $_SESSION['user_pass'] = $row['s_pass'];

            header("Location: student_dashboard.php");
            exit;
        } else {
            $error_message = "Invalid student credentials. Try again.";
        }
        $stmt->close();
    }

    if(isset($_POST['a_login'])) {
        $a_user = sanitize_input($_POST['a_user']);
        $a_pswd = sanitize_input($_POST['a_pswd']);

        $sql = "SELECT * FROM admin WHERE a_user = ? AND a_pass = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $a_user, $a_pswd);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            session_start();
            $_SESSION['admin_id'] = $row['a_id'];
            $_SESSION['admin_user'] = $row['a_user'];
            $_SESSION['admin_name'] = $row['a_name'];
            $_SESSION['admin_email'] = $row['a_email'];

            header("Location: a_search.php");
            exit;
        } else {
            $error_message = "Invalid admin credentials. Try again.";
        }
        $stmt->close();
    }

    if(isset($_POST['signup'])) {
        $idno = sanitize_input($_POST['modal-s-idno']);
        $name = sanitize_input($_POST['modal-s-name']);
        $course = sanitize_input($_POST['modal-s-course']);
        $email = sanitize_input($_POST['modal-s-email']);
        $age = sanitize_input($_POST['modal-s-age']);
        $address = sanitize_input($_POST['modal-s-address']);
        $gender = sanitize_input($_POST['modal-s-gender']);
        $password = sanitize_input($_POST['modal-s-pswd']);

        $sql = "INSERT INTO student (s_idno, s_name, s_course, s_email, s_age, s_address, s_gender, s_pass) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssss', $idno, $name, $course, $email, $age, $address, $gender, $password);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $error_message = "Signup failed. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sit-in Login</title>
    <link rel="stylesheet" type="text/css" href="style/slidestyle.css">
    <link rel="stylesheet" type="text/css" href="style/modal.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main">        
        <input type="checkbox" id="chk" aria-hidden="true">

            <div class="student">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="chk" aria-hidden="true">Sit-In Monitoring</label>
                    <h2>Student Login &nbsp(<a href="#" onclick="document.getElementById('studentModal').style.display='block'">Signup?</a>)</h2>
                    <input type="text" name="s_idno" placeholder="ID Number" required="">
                    <input type="password" name="s_pswd" placeholder="Password" required="">
                    <button type="submit" name="s_login">Login</button>
                    <?php if (!empty($error_message) && isset($_POST['s_login'])) : ?>
                        <div class="error-message">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>       
                </form>
            </div>

            <div class="admin">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="chk" aria-hidden="true">Admin Login</label>
                    <input type="username" name="a_user" placeholder="Username" required="">
                    <input type="password" name="a_pswd" placeholder="Password" required="">
                    <button type="submit" name="a_login">Login</button>
                    <?php if (!empty($error_message) && isset($_POST['a_login'])) : ?>
                        <div class="error-message">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?> 
                </form>
            </div>

            <div id="studentModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('studentModal').style.display='none'">&times;</span>
                    <h2>Student Signup</h2>
                    <form method="POST" action="index.php">
                        <label class="modal-label" for="modal-s-idno">ID Number:</label>
                        <input class="modal-input" type="text" id="modal-s-idno" name="modal-s-idno" placeholder="Enter ID Number" required><br>

                        <label class="modal-label" for="modal-s-name">Name:</label>
                        <input class="modal-input" type="text" id="modal-s-name" name="modal-s-name" placeholder="Enter Name" required><br>

                        <label class="modal-label" for="modal-s-course">Course:</label>
                        <input class="modal-input" type="text" id="modal-s-course" name="modal-s-course" placeholder="Enter Course" required><br>

                        <label class="modal-label" for="modal-s-email">Email:</label>
                        <input class="modal-input" type="email" id="modal-s-email" name="modal-s-email" placeholder="Enter Email" required><br>

                        <label class="modal-label" for="modal-s-age">Age:</label>
                        <input class="modal-input" type="number" id="modal-s-age" name="modal-s-age" placeholder="Enter Age" required><br>

                        <label class="modal-label" for="modal-s-address">Address:</label>
                        <input class="modal-input" type="text" id="modal-s-address" name="modal-s-address" placeholder="Enter Address" required><br>

                        <label class="modal-label" for="modal-s-gender">Gender:</label>
                        <input class="modal-input" type="text" id="modal-s-gender" name="modal-s-gender" placeholder="Enter Gender" required><br>

                        <label class="modal-label" for="modal-s-pswd">Password:</label>
                        <input class="modal-input" type="password" id="modal-s-pswd" name="modal-s-pswd" placeholder="Enter Password" required><br>

                        <label class="modal-label" for="modal-confirm-pswd">Confirm Password:</label>
                        <input class="modal-input" type="password" id="modal-confirm-pswd" name="modal-confirm-pswd" placeholder="Confirm Password" required><br>

                        <span id="message"></span>

                        <button type="submit" name="signup">Signup</button>
                            <?php if (!empty($error_message) && isset($_POST['signup'])) : ?>
                                <div class="error-message">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?> 
                    </form>
                </div>
            </div>                           

    <script>
        window.onclick = function(event) {
            var modal = document.getElementById('studentModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function checkPasswordMatch() {
            var password = document.getElementById("modal-s-pswd").value;
            var confirmPassword = document.getElementById("modal-confirm-pswd").value;

            if (password == confirmPassword) {
                document.getElementById("message").innerHTML = "Passwords match!";
            } else {
                document.getElementById("message").innerHTML = "Passwords do not match!";
            }
        }
    </script>        
    </div>
</body>
</html>
