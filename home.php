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
<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Welcome, <?php echo ucfirst($_SESSION['role']); ?>!</span>
            <form method="POST" action="logout.php">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Home Page</h2>

        <div class="text-center mt-4">
            <label class="form-label"><strong>Select an Option:</strong></label>
            <select class="form-select w-50 mx-auto">
                <option value="option1">Option 1</option>
                <option value="option2">Option 2</option>
                <option value="option3">Option 3</option>
            </select>
        </div>
    </div>

</body>
</html>
