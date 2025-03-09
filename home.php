<?php
session_start();

// Redirect to login if role is not set
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php'; // Include database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Restaurant Queue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Restaurant Queue Management</h2>

    <!-- Display different content for Admins and Guests -->
    <?php if ($_SESSION['role'] == "admin"): ?>
        <h4 class="text-success text-center">Welcome, Admin</h4>
    <?php else: ?>
        <h4 class="text-primary text-center">Welcome, Guest</h4>
    <?php endif; ?>

    <!-- Form to Add to Waitlist (Visible to All) -->
    <div class="card p-4 my-4">
        <h4>Add Yourself to the Waitlist</h4>
        <form id="waitlistForm">
            <div class="mb-3">
                <label for="name" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="party_size" class="form-label">Party Size</label>
                <input type="number" class="form-control" id="party_size" required>
            </div>
            <button type="submit" class="btn btn-primary">Join Waitlist</button>
        </form>
    </div>

    <!-- Waitlist Table (Visible to All) -->
    <div class="card p-4">
        <h4>Current Waitlist</h4>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Party Size</th>
                <th>Status</th>
                <?php if ($_SESSION['role'] == "admin"): ?>
                    <th>Action</th> <!-- Admins can remove users -->
                <?php endif; ?>
            </tr>
            </thead>
            <tbody id="waitlistTable">
            <!-- Data will be inserted here dynamically -->
            </tbody>
        </table>
    </div>

    <!-- Logout Button -->
    <div class="text-center mt-3">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<script>
    // Fetch Waitlist Data
    function loadWaitlist() {
        $.get("get_waitlist.php", function(data) {
            $("#waitlistTable").html(data);
        });
    }

    // Handle Form Submission
    $("#waitlistForm").submit(function(event) {
        event.preventDefault();
        let name = $("#name").val();
        let party_size = $("#party_size").val();

        $.post("add_to_waitlist.php", { name: name, party_size: party_size }, function(response) {
            alert(response);
            loadWaitlist();
            $("#waitlistForm")[0].reset();
        });
    });

    // Function to remove a customer from the waitlist
    function removeFromWaitlist(id) {
        if (confirm("Are you sure you want to remove this customer?")) {
            $.post("remove_from_waitlist.php", { id: id }, function(response) {
                alert(response);
                loadWaitlist();
            });
        }
    }

    // Load waitlist when page loads
    $(document).ready(loadWaitlist);
</script>

</body>
</html>
