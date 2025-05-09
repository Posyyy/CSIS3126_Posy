<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $waitlistId = intval($_POST['id']);
    $newStatus = $_POST['status'];
    $adminUsername = $_SESSION['username'] ?? 'Unknown';

    $validStatuses = ['Seated', 'Removed'];

    if (!in_array($newStatus, $validStatuses)) {
        echo "Invalid status.";
        exit;
    }

    // Update the waitlist entry status
    $stmt = $conn->prepare("UPDATE waitlist SET status = ? WHERE waitlist_id = ?");
    $stmt->bind_param("si", $newStatus, $waitlistId);

    if ($stmt->execute()) {
        echo "Status updated to $newStatus.";

        // Log the admin action
        $logStmt = $conn->prepare("INSERT INTO admin_logs (admin_username, action) VALUES (?, ?)");
        $actionText = "Updated waitlist ID $waitlistId to status '$newStatus'";
        $logStmt->bind_param("ss", $adminUsername, $actionText);
        $logStmt->execute();
        $logStmt->close();
    } else {
        echo "Error updating status.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
