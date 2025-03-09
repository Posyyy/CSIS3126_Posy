<?php
session_start();
include 'db_connect.php';

if ($_SESSION['role'] !== "admin") {
    echo "Access Denied!";
    exit();
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM waitlist WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Customer removed from waitlist.";
    } else {
        echo "Error removing customer.";
    }

    $stmt->close();
}

$conn->close();
?>
