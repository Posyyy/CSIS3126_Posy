<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch staff from database
    $stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $staff = $result->fetch_assoc();

    if ($staff && password_verify($password, $staff['password_hash'])) {
        // Store staff session
        $_SESSION['staff_id'] = $staff['staff_id'];
        $_SESSION['staff_name'] = $staff['name'];
        $_SESSION['staff_role'] = $staff['role'];
        $_SESSION['restaurant_id'] = $staff['restaurant_id'];

        header("Location: index.html"); // Redirect after login
        exit();
    } else {
        echo "<script>alert('Invalid email or password'); window.location.href='index.php';</script>";
    }
}
?>
