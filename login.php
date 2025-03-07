<?php
session_start();

$adminPassword = "SecurePass123"; // Change this to a strong password

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['role'])) {
        die("Invalid role selection.");
    }

    $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);

    if ($role === "admin") {
        if (!isset($_POST['admin_password']) || $_POST['admin_password'] !== $adminPassword) {
            die("Incorrect admin password.");
        }
        $_SESSION['role'] = "admin";
    } else {
        $_SESSION['role'] = "guest";
    }

    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow-lg" style="width: 25rem;">
        <h2 class="text-center">Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Select Role:</label>
                <select name="role" id="role" class="form-select" onchange="togglePasswordField()">
                    <option value="guest">Guest</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="mb-3" id="admin-password-field" style="display: none;">
                <label class="form-label">Admin Password:</label>
                <input type="password" name="admin_password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script>
    function togglePasswordField() {
        let role = document.getElementById("role").value;
        let passwordField = document.getElementById("admin-password-field");
        passwordField.style.display = role === "admin" ? "block" : "none";
    }
    </script>

</body>
</html>
