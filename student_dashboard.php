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

// Get the current date
$current_date = date('Y-m-d');

// Fetch available event details from the database, excluding past events
$query_events = "SELECT *, DATEDIFF(date, '$current_date') AS remaining_days FROM event_details WHERE date >= '$current_date'";
$result_events = $conn->query($query_events);

// Fetch enrolled events for the student
$query_enrolled_events = "
    SELECT ed.eventId, ed.eventName, ed.eventCategory, ed.eventDetails, ed.date, ed.time, ed.location, ed.suborganizer, ed.noOfparticipants, DATEDIFF(ed.date, '$current_date') AS remaining_days 
    FROM enrolled_events ee 
    JOIN event_details ed ON ee.eventId = ed.eventId 
    WHERE ee.studentName = '$student_name' AND ed.date >= '$current_date'
";
$result_enrolled_events = $conn->query($query_enrolled_events);

// Handle event cancellation by the student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_event_id'])) {
    $cancel_event_id = $_POST['cancel_event_id'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Delete the enrollment record
        $delete_query = "DELETE FROM enrolled_events WHERE eventId = '$cancel_event_id' AND studentName = '$student_name'";
        if ($conn->query($delete_query) !== TRUE) {
            throw new Exception("Error deleting enrollment record: " . $conn->error);
        }

        // Decrease the number of participants in the event_details table
        $update_query = "UPDATE event_details SET noOfparticipants = noOfparticipants - 1 WHERE eventId = '$cancel_event_id'";
        if ($conn->query($update_query) !== TRUE) {
            throw new Exception("Error updating participants count: " . $conn->error);
        }

        // Commit transaction
        $conn->commit();

        echo "<script>alert('You have successfully cancelled your enrollment for the event.'); window.location.href='student_dashboard.php';</script>";
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        $conn->rollback();
        echo "<script>alert('Error cancelling the event: " . $e->getMessage() . "');</script>";
    }
}
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
        <p style="font-size: 20px;"><strong>Name:</strong> <?php echo htmlspecialchars($student_name); ?></p>
        
        <p style="font-size: 20px;"><strong>Password:</strong> <?php echo htmlspecialchars($student_password); ?></p>
        
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
                <th>Remaining Days</th>
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

                    // Show remaining days or 'Today'
                    $remaining_days = $event['remaining_days'];
                    if ($remaining_days == 0) {
                        echo "<td>Today</td>";
                    } else {
                        echo "<td>" . htmlspecialchars($remaining_days) . " day(s)</td>";
                    }

                    echo "<td><a href='event_Sdetail.php?event_id=" . urlencode($event['eventId']) . "'>Details</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No upcoming events found.</td></tr>";
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
                <th>Remaining Days</th>
                <th>Action</th>
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

                    // Show remaining days or 'Today'
                    $remaining_days = $event['remaining_days'];
                    if ($remaining_days == 0) {
                        echo "<td>Today</td>";
                    } else {
                        echo "<td>" . htmlspecialchars($remaining_days) . " day(s)</td>";
                    }

                    echo "<td>
                        <form method='POST' action='student_dashboard.php' onsubmit ='return confirmDelete()'>
                            <input type='hidden' name='cancel_event_id' value='" . htmlspecialchars($event['eventId']) . "'>
                            <input type='submit' value='Cancel' class='button'>
                        </form>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No enrolled events found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script>
        function confirmDelete() {
            return confirm('Are you sure you want to cancel this event?');
        }
    </script>

<script src="js/organizer_profile.js"></script>
</body>
</html>
