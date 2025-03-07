<?php
session_start();

// Ensure only admin can update status
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    die("Unauthorized access.");
}

include 'db.php'; // Ensure database connection

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = ($_GET['status'] === 'seated') ? 'seated' : 'removed';

    $sql = "UPDATE Waitlist SET status = ? WHERE waitlist_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        die("Error updating status.");
    }
}

$conn->close();
?>
