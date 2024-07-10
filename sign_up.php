<!--  <?php
// Include database connection
require_once 'db_connection.php';

$error_message = "";
$success_message = ""; // Initialize success message variable

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $college = $_POST['college'];
    $register = $_POST['register'];
    $email = $_POST['email'];
    $passkey = $_POST['passkey'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate based on role selection
    if ($role === 'owner') {
        // Organizer role validation
        $query = "SELECT * FROM uniorg WHERE regid = '$register' AND collegename = '$college' AND passkey = '$passkey'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Check if college name already exists in collegereg table
            $checkQuery = "SELECT COUNT(*) as count FROM collegereg WHERE collegename = ?";
            $stmt = $conn->prepare($checkQuery);
            $stmt->bind_param("s", $college);
            $stmt->execute();
            $checkResult = $stmt->get_result();
            $data = $checkResult->fetch_assoc();

            if ($data['count'] > 0) {
                $error_message = "College name '$college' already exists.";
            } else {
                // Insert data into collegereg table
                $insertQuery = "INSERT INTO collegereg (collegename, password, email)
                                VALUES ('$college', '$password', '$email')";

                if ($conn->query($insertQuery) === TRUE) {
                    $success_message = "Organizer registration successful."; // Set success message
                } else {
                    $error_message = "Error inserting record: " . $conn->error;
                }
            }
        } else {
            $error_message = "Organizer validation failed. Please check your registration ID, college, and passkey.";
        }
    } elseif ($role === 'user') {
        // User role validation
        $query = "SELECT * FROM unistud WHERE regid = '$register' AND college_name = '$college' AND passkey = '$passkey'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Check if registration ID already exists in studentreg table
            $checkQuery = "SELECT COUNT(*) as count FROM studentreg WHERE registration_id = ?";
            $stmt = $conn->prepare($checkQuery);
            $stmt->bind_param("s", $register);
            $stmt->execute();
            $checkResult = $stmt->get_result();
            $data = $checkResult->fetch_assoc();

            if ($data['count'] > 0) {
                $error_message = "Registration ID '$register' already exists. Please choose a different registration ID.";
            } else {
                // Retrieve student name from unistud table
                $nameQuery = "SELECT student_name FROM unistud WHERE regid = '$register'";
                $nameResult = $conn->query($nameQuery);

                if ($nameResult->num_rows > 0) {
                    $row = $nameResult->fetch_assoc();
                    $name = $row['student_name'];

                    // Insert data into studentreg table
                    $insertQuery = "INSERT INTO studentreg (name, password, email, registration_id)
                                    VALUES ('$name', '$password', '$email', '$register')";

                    if ($conn->query($insertQuery) === TRUE) {
                        $success_message = "User registration successful."; // Set success message
                    } else {
                        $error_message = "Error inserting record: " . $conn->error;
                    }
                } else {
                    $error_message = "Error retrieving name from unistud table.";
                }
            }
        } else {
            $error_message = "User validation failed. Please check your registration ID, college, and passkey.";
        }
    } else {
        $error_message = "Invalid role selected."; // Handle other roles if necessary
    }

    // Close connection (if not included in db_connection.php)
    $conn->close();
}
?> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="css/sign_upStyle.css">
</head>
<body>
    <nav id="navbar">
        <div id="titleName">
            <h2>Inter College Event Management System</h2>
        </div>
        <ul>
            <li class="item"><a href="index.html">Home</a></li>
            <li class="item"><a href="#">About US</a></li>
            <li class="item"><a href="sign_up.php">Sign Up</a></li>
            <li class="item"><a href="login.html">Login</a></li>
        </ul>
    </nav>

    <div class="sign_up">
        <form action="sign_up.php" method="post">
            <h1>Sign Up</h1>
            <input type="hidden" id="error_message" value="<?php echo htmlspecialchars($error_message); ?>">
            <input type="hidden" id="success_message" value="<?php echo htmlspecialchars($success_message); ?>">

            <label for="college">College:</label><br>
            <select id="college" name="college">
                <option value="">--Please choose a College--</option>
                <option value="Everest Engineering College">Everest Engineering College</option>
                <option value="National College of Information Technology">NCIT</option>
                <option value="Cosmos Engineering College">Cosmos Engineering College</option>
                <option value="Nepal Engineering College">Nepal Engineering College</option>
            </select><br><br>

            <label for="register">Register ID:</label><br>
            <input type="text" id="register" name="register" placeholder="Enter your Register ID"><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" placeholder="Enter your Email ID"><br>

            <label for="passkey">Passkey:</label><br>
            <input type="text" id="passkey" name="passkey" placeholder="Enter your passkey"><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required placeholder="Enter your password"><br><br>

            <label>Are you an Organizer or a User?</label><br>
            <input type="radio" id="owner" name="role" value="owner" required>
            <label for="owner">Organizer</label><br>
            <input type="radio" id="user" name="role" value="user" required>
            <label for="user">User</label><br><br>

            <input type="submit" value="Sign Up"><br><br>

            <span class="login-link">
                Already have an account?
                <a href="javascript:void(0);" onclick="openModal()"> Log in here</a>
            </span>
        </form>
      </div>

    <footer>
        <p>&copy; 2024 Inter College Event Management System. All rights reserved.</p>
    </footer>

    <script>
        function openModal() {
            // This function will open the login modal on the index page
            window.location.href = 'index.html#login';
        }

        // Check for error message and display alert
        document.addEventListener('DOMContentLoaded', function() {
            var errorMessage = document.getElementById('error_message').value;
            var successMessage = document.getElementById('success_message').value;

            if (errorMessage.trim() !== '') {
                alert(errorMessage);
            }

            if (successMessage.trim() !== '') {
                alert(successMessage);
            }
        });
    </script>
</body>
</html> --> 
