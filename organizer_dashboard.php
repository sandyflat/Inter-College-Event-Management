<!-- organizer_dashboard.php -->
<?php
session_start(); // Start the session

// Check if the organizer is logged in
if (!isset($_SESSION['organizer_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login_organizer.php';</script>";
    exit();
}

// Include database connection
require_once 'db_connection.php';

// Retrieve organizer details from the session
$organizer_name = $_SESSION['organizer_name'];
$organizer_email = $_SESSION['organizer_email'];
$organizer_password = $_SESSION['organizer_password'];

// Fetch all event details from the database
$query_all_events = "SELECT * FROM event_details";
$result_all_events = $conn->query($query_all_events);

// Fetch registered event details for the logged-in organizer
$query_registered_events = "SELECT * FROM event_details WHERE organizer = '$organizer_name'";
$result_registered_events = $conn->query($query_registered_events);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard</title>
    <link rel="stylesheet" href="cssfile/organizer_dashboardStyle.css">
</head>
<body>
<nav>
        <div class="navbar">
          <div class="logo"><a href="#">Organizer Dashboard</a></div>
          </div>
      </nav>
    
    <div class="main-content1">
        <div id="profileInfo">
            <p><strong>Organizer Name:</strong> <?php echo htmlspecialchars($organizer_name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($organizer_email); ?></p>
            <p><strong>Password:</strong> <?php echo htmlspecialchars($organizer_password); ?></p>
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
                if ($result_all_events->num_rows > 0) {
                    while ($event = $result_all_events->fetch_assoc()) {
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
                        echo "<td><a href='event_Odetail.php?event_id=" . urlencode($event['eventId']) . "'>Details</a></td>";
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
        <h2>Registered Events</h2>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display registered event details for the logged-in organizer
                if ($result_registered_events->num_rows > 0) {
                    while ($event = $result_registered_events->fetch_assoc()) {
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
                        echo "<td><a href='event_Odetail.php?event_id=" . urlencode($event['eventId']) . "'>Details</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No registered events found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <button onclick="location.href='create_event.php'" class="button">Create New Event</button>
    </div>

  
    <script src="js/organizer_profile.js"></script>
</body>
</html>
