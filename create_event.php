<!-- create_event.html -->
<?php
session_start(); // Start the session

// Check if the organizer is logged in
if (!isset($_SESSION['organizer_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login_organizer.php';</script>";
    exit();
}

// Include database connection
require_once 'db_connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $eventName = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $organizer = $_SESSION['organizer_name']; // Organizer name from session
    $subOrganizer = $_POST['sub-name'];
    $eventCategory = $_POST['eventCategory'];
    $eventDetails = $_POST['largeTextInput'];

    // Insert event details into the database
    $query = "INSERT INTO event_details (eventName, date, time, location, organizer, subOrganizer, eventCategory, eventDetails) 
              VALUES ('$eventName', '$date', '$time', '$location', '$organizer', '$subOrganizer', '$eventCategory', '$eventDetails')";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Event created successfully'); window.location.href='organizer_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href='create_event.php';</script>";
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Events</title>
    <link rel="stylesheet" href="cssfile/create_eventStyle.css">
    <style>
        textarea {
          width: 100%; /* Full width */
          height: 200px; /* Fixed height */
          padding: 10px; /* Padding inside the textarea */
          border: 1px solid #ccc; /* Border style */
          border-radius: 4px; /* Rounded corners */
          box-sizing: border-box; /* Include padding and border in the element's total width and height */
          font-family: Arial, sans-serif; /* Font style */
          font-size: 14px; /* Font size */
          resize: none; /* Disable manual resizing */
        }
    </style>
</head>
<body>
<nav>
        <div class="navbar">
          <div class="logo"><a href="#">Inter College Event Management System</a></div>
          
        </div>
      </nav>

    <div class="create-event">
        <form action="create_event.php" method="post">
            <h1>Create Event</h1>
            <label for="name">Event Name:</label><br>
            <input type="text" id="name" name="name" placeholder="Enter your Event Name" required><br>

            <label for="event-type">Event Category:</label><br>
            <select id="event-category" name="eventCategory" required>
                <option value="">--Please choose event type--</option>
                <option value="Workshops">Workshops</option>
                <option value="eSports">eSports</option>
                <option value="Cultural">Cultural Events</option>
                <option value="Sports">Sports Events</option>
                <option value="Social Service Events">Social and Community Service Events</option>
                <option value="Professional Development Events">Professional Development Events</option>
                <option value="Recreational and Leisure Events">Recreational and Leisure Events</option>
                <option value="Technical Events">Technical Events</option>
                <option value="Health and Wellness Events">Health and Wellness Events</option>
            </select><br><br>

            <label for="date">Event Date:</label><br>
            <input type="date" id="date" name="date" placeholder="Enter your Event Date" required><br><br>

            <label for="time">Time:</label><br>
            <input type="time" id="time" name="time" placeholder="Enter your Event Time" required><br><br>

            <label for="location">Event Location:</label><br>
            <input type="text" id="location" name="location" placeholder="Enter Event Location" required><br>

            <label for="sub-name">Sub-Organizer Name:</label><br>
            <input type="text" id="sub-name" name="sub-name" placeholder="Enter Sub-Organizer Name" required><br><br>

            <label for="detail">Event Detail:</label><br>
            <textarea name="largeTextInput" placeholder="Enter your text here..." required></textarea><br>

            <input type="submit" value="Submit"><br><br>
        </form>
    </div>

</body>
</html>

