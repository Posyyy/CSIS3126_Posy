<?php
session_start();
include 'db.php'; // Ensure this connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials (modify according to your DB structure)
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password); // Assuming passwords are stored in plaintext (not recommended)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: admin_dashboard.php"); // Redirect to admin panel
        exit();
    } else {
        echo "<script>alert('Invalid username or password!'); window.location.href='index.php';</script>";
    }
}
?>
