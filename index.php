<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurant Queue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Restaurant Queue</a>
        <div class="d-flex">
            <?php if (!isset($_SESSION['user_role'])): ?>
                <form method="post" action="login.php" class="d-flex">
                    <select name="user_role" class="form-select me-2">
                        <option value="guest">Guest</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            <?php else: ?>
                <span class="navbar-text text-white me-3">Logged in as: <?php echo ucfirst($_SESSION['user_role']); ?></span>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Home Section -->
<div class="container mt-5">
    <h2 class="text-center">Welcome to the Restaurant Queue System</h2>

    <!-- Dropdown Menu -->
    <div class="mb-4">
        <label for="options" class="form-label">Select an Option:</label>
        <select id="options" class="form-select">
            <option value="view_waitlist">View Waitlist</option>
            <option value="add_customer">Add Customer</option>
        </select>
    </div>

    <!-- Waitlist Table -->
    <div id="waitlist-section">
        <h3>Waitlist</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Party Size</th>
                    <th>Status</th>
                    <th>Arrival Time</th>
                </tr>
            </thead>
            <tbody id="waitlist-body">
                <!-- Data will be loaded here using AJAX -->
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    // Fetch waitlist data from get_waitlist.php
    function loadWaitlist() {
        $.ajax({
            url: 'get_waitlist.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let tableContent = '';
                data.forEach(function(row) {
                    tableContent += `
                        <tr>
                            <td>${row.waitlist_id}</td>
                            <td>${row.name}</td>
                            <td>${row.phone_number}</td>
                            <td>${row.party_size}</td>
                            <td>${row.status}</td>
                            <td>${row.arrival_time}</td>
                        </tr>`;
                });
                $('#waitlist-body').html(tableContent);
            },
            error: function() {
                alert('Error loading waitlist data.');
            }
        });
    }

    loadWaitlist();
});
</script>

</body>
</html>
