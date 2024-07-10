<!-- login_organizer.php -->
<?php
session_start(); // Start the session

// Include database connection
require_once 'db_connection.php';

// Process form submission for organizer login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate college and password against 'collegereg' table
    $query = "SELECT * FROM collegereg WHERE collegename = '$college' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Fetch organizer details
        $organizer = $result->fetch_assoc();

        // Store organizer details in session
        $_SESSION['organizer_id'] = $organizer['id'];
        $_SESSION['organizer_name'] = $college; // Set organizer_name to the selected college name
        $_SESSION['organizer_email'] = $organizer['email']; // Assuming the 'collegereg' table has an 'email' column
        $_SESSION['organizer_college'] = $college; // Store the college name (optional if needed separately)
        $_SESSION['organizer_password'] = $password; // Store the password

        // Login successful
        echo "<script>alert('Organizer Login successful'); window.location.href='organizer_dashboard.php';</script>";
        exit();
    } else {
        // Login failed
        echo "<script>alert('Organizer Login failed. Please check your college and password.'); window.location.href='login_organizer.php';</script>";
        exit();
    }
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Login</title>
    <link rel="stylesheet" href="cssfile/loginStyle.css">
</head>
<body background="images/fakebg1.png">
    <div class="login">
        <form action="login_organizer.php" method="post">
            <a href="index.html" class="close">&times;</a>
            <h1>Organizer Login</h1>
            <label for="college-select">College:</label><br>
            <select id="college-select" name="college" required>
                <option value="">--Please choose a College--</option>
                <option value="Everest Engineering College">Everest Engineering College</option>
                <option value="National College of Information Technology">NCIT</option>
                <option value="Cosmos Engineering College">Cosmos Engineering College</option>
                <option value="Nepal Engineering College">Nepal Engineering College</option>
            </select><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required placeholder="Enter your password"><br>
            <input type="checkbox" id="show-password"> Show Password<br><br>

            <input type="submit" value="Login"><br><br>
            <p>Don't have an account? <a href="signup_organizer.php">Register</a></p>
        </form>
    </div>

    <script type="text/javascript">
        document.getElementById('show-password').addEventListener('change', function () {
            var passwordField = document.getElementById('password');
            if (this.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        });
    </script>
</body>
</html>
