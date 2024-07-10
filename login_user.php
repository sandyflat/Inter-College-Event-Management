<!-- login_user.php -->
<?php
session_start(); // Start the session

// Include database connection
require_once 'db_connection.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name'];
    $password = $_POST['password'];

    // Query to check username and password
    $query = "SELECT * FROM studentreg WHERE name = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Fetch student details
        $student = $result->fetch_assoc();

        // Store student details in session
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['name'];
        $_SESSION['student_email'] = $student['email'];
        $_SESSION['student_password'] = $student['password'];

        // Redirect to student dashboard upon successful login
        echo "<script>alert('Login successful'); window.location.href='student_dashboard.php';</script>";
        exit(); // Stop script execution after redirection
    } else {
        // Login failed
        echo "<script>alert('Login failed. Please check your username and password.'); window.location.href='login_user.php';</script>";
        exit(); // Stop script execution after redirection
    }

    // Close connection (although not necessary for script flow if not used further)
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="cssfile/loginStyle.css">
</head>
<body background="images/fakebg1.png">
    <div class="login">
        <form action="login_user.php" method="post"> <!-- Corrected form action to post to itself -->
            <a href="index.html" class="close">&times;</a>
            <h1> User Login</h1>
            <label for="name">Enter username:</label><br>
            <input type="text" id="name" name="name" required placeholder="Enter your username"><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required placeholder="Enter your password"><br>
            <input type="checkbox" id="show-password"> Show Password<br><br>

            <input type="submit" value="Login"><br><br>
            <p>Don't have an account? <a href="signup_user.php">Register</a></p>
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

