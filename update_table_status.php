<?php
session_start(); // Add this to access session data
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableId = intval($_POST['table_id']);
    $newStatus = $_POST['status'];
    $adminUsername = $_SESSION['username'] ?? 'Unknown'; // fallback if not set

    $validStatuses = ['Available', 'Reserved', 'Occupied'];

    if (!in_array($newStatus, $validStatuses)) {
        echo "Invalid status.";
        exit;
    }

    // Update table status
    $stmt = $conn->prepare("UPDATE tables SET status = ? WHERE table_id = ?");
    $stmt->bind_param("si", $newStatus, $tableId);

    if ($stmt->execute()) {
        echo "Table status updated to $newStatus.";

        // Log the admin action
        $logStmt = $conn->prepare("INSERT INTO admin_logs (admin_username, action) VALUES (?, ?)");
        $actionText = "Updated table ID $tableId to status '$newStatus'";
        $logStmt->bind_param("ss", $adminUsername, $actionText);
        $logStmt->execute();
        $logStmt->close();
    } else {
        echo "Error updating table status.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
