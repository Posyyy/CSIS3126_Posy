<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['status'])) {
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    // Validate status options
    $allowed_statuses = ['Seated', 'Removed', 'Waiting'];
    if (!in_array($status, $allowed_statuses)) {
        echo "Invalid status update!";
        exit();
    }

    // Update the waitlist status
    $stmt = $conn->prepare("UPDATE Waitlist SET status = ? WHERE waitlist_id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo "Status updated successfully!";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
