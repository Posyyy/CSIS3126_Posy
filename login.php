<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role']; // Get selected role

    if ($role == "admin") {
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
                <select name="role" class="form-select">
                    <option value="guest">Guest</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

</body>
</html>
