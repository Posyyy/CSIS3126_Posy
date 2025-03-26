<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$email || !$password) {
        die("⚠️ Email and password are required.");
    }

    $stmt = $conn->prepare("SELECT staff_id, password_hash, role FROM staff WHERE email = ?");
    if (!$stmt) {
        die("❌ Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Secure session
            session_regenerate_id(true);
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            $_SESSION['staff'] = in_array($role, ['manager', 'host', 'server', 'admin']);

            // Redirect all staff to admin_dashboard.php
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "❌ Invalid credentials.";
        }
    } else {
        echo "❌ User not found.";
    }

    $stmt->close();
}
$conn->close();
?>
