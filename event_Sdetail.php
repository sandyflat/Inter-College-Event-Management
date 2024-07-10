<!-- event_Sdetail.html -->
<!-- event_Sdetail.php -->
<?php
session_start(); // Start the session

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login_user.php';</script>";
    exit();
}

// Include database connection
require_once 'db_connection.php';

// Initialize event details variables
$event = array(
    'eventName' => '',
    'eventCategory' => '',
    'date' => '',
    'time' => '',
    'location' => '',
    'noOfparticipants' => '',
    'organizer' => '',
    'suborganizer' => '',
    'eventDetails' => ''
);

// Fetch event details if event_id is provided in URL
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Query to fetch event details
    $query = "SELECT * FROM event_details WHERE eventId = '$event_id'";
    $result = $conn->query($query);

    // Check if event exists
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
    } else {
        echo "<script>alert('Event not found.'); window.location.href='student_dashboard.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='student_dashboard.php';</script>";
    exit();
}

// Handle enrollment
if (isset($_POST['enroll'])) {
    // Get student name from the session
    $student_name = $_SESSION['student_name'];

    // Check if the student is already enrolled in the event
    $check_enrollment = "SELECT * FROM enrolled_events WHERE eventId = '$event_id' AND studentName = '$student_name'";
    $enrollment_result = $conn->query($check_enrollment);

    if ($enrollment_result->num_rows > 0) {
        echo "<script>alert('You are already enrolled in this event.'); window.location.href='student_dashboard.php';</script>";
    } else {
        // Update the number of participants in the event_details table
        $update_query = "UPDATE event_details SET noOfparticipants = noOfparticipants + 1 WHERE eventId = '$event_id'";
        $conn->query($update_query);

        // Insert enrollment record into enrolled_events table
        $insert_query = "INSERT INTO enrolled_events (eventId, studentName) VALUES ('$event_id', '$student_name')";
        $conn->query($insert_query);

        echo "<script>alert('Enrollment successful!'); window.location.href='student_dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="cssfile/event_detailStyle.css">
</head>
<body>
<nav>
        <div class="navbar">
          <div class="logo"><a href="#">Details</a></div>
          
        </div>
      </nav>

    <div class="event-details">
        <div class="event-info">
            <div class="main-contain">
                <p><strong>Event Name:</strong> <?php echo htmlspecialchars($event['eventName']); ?></p>
                <p><strong>Event Category:</strong> <?php echo htmlspecialchars($event['eventCategory']); ?></p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
                <p><strong>Time:</strong> <?php echo htmlspecialchars($event['time']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                <p><strong>Number of Participants:</strong> <?php echo htmlspecialchars($event['noOfparticipants']); ?></p>
                <p><strong>Organizer Name:</strong> <?php echo htmlspecialchars($event['organizer']); ?></p>
                <p><strong>Sub Organizer:</strong> <?php echo htmlspecialchars($event['suborganizer']); ?></p>
                <p><strong>Event Details:</strong> <?php echo htmlspecialchars($event['eventDetails']); ?></p>
                <form method="post">
                    <button type="submit" name="enroll" class="button">Enroll</button>
                </form>
            </div>
        </div>
    </div>


</body>
</html>
