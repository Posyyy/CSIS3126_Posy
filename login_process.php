<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Simple hardcoded login validation (replace with database check)
    if ($role === "admin" && $username === "admin" && $password === "admin123") {
        $_SESSION['role'] = "admin";
        header("Location: home.php");
    } elseif ($role === "guest") {
        $_SESSION['role'] = "guest";
        header("Location: home.php");
    } else {
        echo "<script>alert('Invalid credentials'); window.location.href='login.php';</script>";
    }
}
?>
