<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow-lg text-center" style="width: 25rem;">
        <h2>Welcome, <?php echo ucfirst($_SESSION['role']); ?>!</h2>

        <?php if ($_SESSION['role'] === "admin"): ?>
            <p>You have full access to the system.</p>
            <a href="admin_dashboard.php" class="btn btn-success w-100">Go to Admin Dashboard</a>
        <?php else: ?>
            <p>You are logged in as a Guest.</p>
        <?php endif; ?>

        <a href="logout.php" class="btn btn-danger mt-3 w-100">Logout</a>
    </div>

</body>
</html>
