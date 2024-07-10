<!-- signup_user.php -->
<?php
// Include database connection
require_once 'db_connection.php';

$error_message = "";
$success_message = ""; // Initialize success message variable

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $college = $_POST['college'];
    $register = $_POST['register'];
    $email = $_POST['email'];
    $passkey = $_POST['passkey'];
    $password = $_POST['password'];
    $confirm_password = $_POST['Confirm-password'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $error_message = "Password and confirm password do not match.";
    } else {
        // Validate and process signup
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
            // Check if student name, registration ID, and college match in unistud table
            $checkStudentQuery = "SELECT COUNT(*) as count FROM unistud WHERE regid = ? AND student_name = ? AND college_name = ?";
            $stmt = $conn->prepare($checkStudentQuery);
            $stmt->bind_param("sss", $register, $name, $college);
            $stmt->execute();
            $checkStudentResult = $stmt->get_result();
            $studentData = $checkStudentResult->fetch_assoc();

            if ($studentData['count'] > 0) {
                // Insert data into studentreg table
                $insertQuery = "INSERT INTO studentreg (name, password, email, registration_id)
                                VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("ssss", $name, $password, $email, $register);

                if ($stmt->execute()) {
                    $success_message = "User registration successful.";
                    echo '<script>window.location.href = "index.html";</script>';
                    exit();
                } else {
                    $error_message = "Error inserting record: " . $stmt->error;
                }
            } else {
                $error_message = "Student information does not match records. Please verify your details.";
            }
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up</title>
    <link rel="stylesheet" href="cssfile/sign_upStyle.css">
</head>
<body background="images/fakebg1.png">

<div class="sign_up">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <a href="index.html" class="close">&times;</a>
        <h1>User Sign Up</h1>

        <?php if (!empty($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php elseif (!empty($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" placeholder="Enter your Name" required><br><br>

        <label for="college">College:</label><br>
        <select id="college" name="college" required>
            <option value="">--Please choose a College--</option>
            <option value="Everest Engineering College">Everest Engineering College</option>
            <option value="National College of Information Technology">NCIT</option>
            <option value="Cosmos Engineering College">Cosmos Engineering College</option>
            <option value="Nepal Engineering College">Nepal Engineering College</option>
        </select><br><br>

        <label for="register">Register ID:</label><br>
        <input type="text" id="register" name="register" placeholder="Enter your Register ID" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" placeholder="Enter your Email ID" required><br><br>

        <label for="passkey">Passkey:</label><br>
        <input type="password" id="passkey" name="passkey" placeholder="Enter your passkey" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required placeholder="Enter your password" required><br><br>

        <label for="Confirm-password">Confirm Password:</label><br>
        <input type="password" id="Confirm-password" name="Confirm-password" required placeholder="Confirm Password" required><br><br>

        <input type="checkbox" id="show-passwords" onclick="togglePasswordVisibility()"> Show Passwords<br><br>

        <input type="submit" value="Sign Up"><br><br>

        <span class="login-link">
            Already have an account?
            <a href="login_user.php">Log in</a>
        </span>
    </form>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordFields = document.querySelectorAll('#register, #passkey, #password, #Confirm-password');
        passwordFields.forEach(field => {
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        });
    }

    // Additional client-side validation to ensure password and confirm password match
    document.querySelector('form').addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const confirm_password = document.getElementById('Confirm-password').value;

        if (password !== confirm_password) {
            event.preventDefault(); // Prevent form submission
            document.querySelector('.error').innerHTML = "Password and confirm password do not match.";
        }
    });
</script>
</body>
</html>
