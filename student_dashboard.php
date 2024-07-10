<!-- student_dashboard.php -->
<?php
session_start(); // Start the session

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login_user.php';</script>";
    exit();
}

// Include database connection
require_once 'db_connection.php';

// Retrieve student details from the session
$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
$student_email = $_SESSION['student_email'];
$student_password = $_SESSION['student_password'];

// Fetch event details from the database
$query_events = "SELECT * FROM event_details";
$result_events = $conn->query($query_events);

// Fetch enrolled events for the student
$query_enrolled_events = "
    SELECT ed.eventId, ed.eventName, ed.eventCategory, ed.eventDetails, ed.date, ed.time, ed.location, ed.suborganizer, ed.noOfparticipants 
    FROM enrolled_events ee 
    JOIN event_details ed ON ee.eventId = ed.eventId 
    WHERE ee.studentName = '$student_name'
";
$result_enrolled_events = $conn->query($query_enrolled_events);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="cssfile/student_dashboardStyle.css">
</head>
<body>
<nav>
        <div class="navbar">
          <div class="logo"><a href="#">Student Dashboard</a></div>
          
        </div>
      </nav>
    
    <div class="main-content1">
        <div id="profileInfo">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($student_name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($student_email); ?></p>
            <p><strong>Password:</strong> <?php echo htmlspecialchars($student_password); ?></p>
            <button onclick="resetPassword()" class="button">Reset Password</button><br>
            <button onclick="logout()" class="button">Logout</button>
        </div>
    </div>

    <div class="main-content2">
        <h2>Available Events</h2>
        <table id="eventsTable">
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Event Category</th>
                    <th>Event Details</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Organizer</th>
                    <th>Sub Organizer</th>
                    <th>No of Participants</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display fetched event details
                if ($result_events->num_rows > 0) {
                    while ($event = $result_events->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($event['eventId']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['eventName']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['eventCategory']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['eventDetails']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['date']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['time']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['location']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['organizer']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['suborganizer']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['noOfparticipants']) . "</td>";
                        echo "<td><a href='event_Sdetail.php?event_id=" . urlencode($event['eventId']) . "'>Details</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No events found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="main-content3">
        <h2>Enrolled Events</h2>
        <table id="registerEventsTable">
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Event Category</th>
                    <th>Event Details</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Sub Organizer</th>
                    <th>No of Participants</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Display enrolled event details for the logged-in student
                if ($result_enrolled_events->num_rows > 0) {
                    while ($event = $result_enrolled_events->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($event['eventId']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['eventName']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['eventCategory']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['eventDetails']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['date']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['time']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['location']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['suborganizer']) . "</td>";
                        echo "<td>" . htmlspecialchars($event['noOfparticipants']) . "</td>";
                        // echo "<td><a href='event_Sdetail.php?event_id=" . urlencode($event['eventId']) . "'>Details</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No enrolled events found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


    <script src="js/organizer_profile.js"></script>
</body>
</html>
