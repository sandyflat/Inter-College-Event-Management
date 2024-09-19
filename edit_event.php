<!-- edit_event.php -->
<?php
// Include database connection
require_once 'db_connection.php';

// Handle form submission for updating event details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $event_details = $_POST['event_details'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_location = $_POST['event_location'];

    // Get current date
    $current_date = date('Y-m-d');

    // Check if the selected date is in the future
    if ($event_date > $current_date) {
        // Update event details in the database
        $update_query = "UPDATE event_details 
                         SET eventDetails = ?, date = ?, time = ?, location = ? 
                         WHERE eventId = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssssi", $event_details, $event_date, $event_time, $event_location, $event_id);

        if ($stmt->execute()) {
            echo "<script>alert('Event details updated successfully!'); window.location.href='organizer_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating event details: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Event date must be a future date. Please select a valid date.');</script>";
    }
    $stmt->close();
    $conn->close();
}

// Fetch event details for the given event ID (if provided)
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    $query = "SELECT * FROM event_details WHERE eventId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('No event selected.'); window.location.href='organizer_dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
        /* Styles for the pop-up modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #6610f2; /* Semi-transparent background */
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border-radius: 10px;
            width: 500px;
            max-width: 90%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            font-size: 20px;
            font-weight: bold;
        }

        .modal-body input,
        .modal-body textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
        }

        .modal-footer button {
            padding: 10px 20px;
            margin: 10px 5px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .save-btn {
            background-color: #28a745;
            color: white;
        }

        .close-btn {
            background-color: #dc3545;
            color: white;
        }

        /* Button to trigger modal */
        .edit-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<!-- Edit Event Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            Edit Event Details
        </div>
        <div class="modal-body">
            <form method="POST" action="edit_event.php">
                <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['eventId']); ?>">
                <label for="event_details">Event Details:</label>
                <textarea name="event_details" id="event_details" required><?php echo htmlspecialchars($event['eventDetails']); ?></textarea>

                <label for="event_date">Event Date:</label>
                <input type="date" name="event_date" id="event_date" value="<?php echo htmlspecialchars($event['date']); ?>" required>

                <label for="event_time">Event Time:</label>
                <input type="time" name="event_time" id="event_time" value="<?php echo htmlspecialchars($event['time']); ?>" required>

                <label for="event_location">Event Location:</label>
                <input type="text" name="event_location" id="event_location" value="<?php echo htmlspecialchars($event['location']); ?>" required>

                <div class="modal-footer">
                    <button type="button" class="close-btn" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Open the modal when the page loads
    window.onload = function () {
        openModal();
    };

    // Function to open the modal
    function openModal() {
        document.getElementById('editModal').style.display = 'flex';
        validateDateInput(); // Call date validation
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
        window.location.href = 'organizer_dashboard.php'; // Redirect after closing modal
    }

    // Function to ensure the selected date is a future date
    function validateDateInput() {
        var eventDateInput = document.getElementById('event_date');
        var today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
        eventDateInput.setAttribute('min', today); // Set min attribute to current date
    }
</script>

</body>
</html>
