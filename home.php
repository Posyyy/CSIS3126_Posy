<?php
session_start();
include 'db.php';

$restaurant_id = 1; // Replace this dynamically if needed
$restaurant_id = 5;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Queue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Restaurant Queue Management</h2>

    <!-- Customer Form -->
    <div class="card p-4 my-4">
        <h4>Join the Waitlist</h4>
        <form id="waitlistForm">
            <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" name="phone_number" id="phone_number" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="mb-3">
                <label for="party_size" class="form-label">Party Size</label>
                <input type="number" class="form-control" name="party_size" id="party_size" required>
            </div>

            <div class="mb-3">
                <label for="waitlist_type" class="form-label">Waitlist Type</label>
                <select class="form-control" name="waitlist_type" id="waitlist_type" required onchange="toggleReservationTime()">
                    <option value="Walk-in">Walk-in</option>
                    <option value="Reservation">Reservation</option>
                </select>
            </div>

            <div class="mb-3" id="reservation_time_container" style="display: none;">
                <label for="reservation_time" class="form-label">Reservation Time</label>
                <input type="time" class="form-control" name="reservation_time" id="reservation_time">
            </div>

            <button type="submit" class="btn btn-primary">Join Waitlist</button>
        </form>
    </div>

    <!-- Waitlist Table -->
    <div class="card p-4">
        <h4>Current Waitlist</h4>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Party Size</th>
                <th>Type</th>
                <th>Reservation Time</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody id="waitlistTable">
                <!-- Data loads dynamically -->
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleReservationTime() {
        let waitlistType = document.getElementById("waitlist_type").value;
        let timeContainer = document.getElementById("reservation_time_container");

        if (waitlistType === "Reservation") {
            timeContainer.style.display = "block";
            document.getElementById("reservation_time").required = true;
        } else {
            timeContainer.style.display = "none";
            document.getElementById("reservation_time").required = false;
        }
    }

    // Fetch Waitlist Data
    function loadWaitlist() {
        $.get("get_waitlist.php", function(data) {
            $("#waitlistTable").html(data);
        });
    }

    // Handle Form Submission
    $("#waitlistForm").submit(function(event) {
        event.preventDefault();

        $.post("add_to_waitlist.php", $("#waitlistForm").serialize(), function(response) {
            alert(response);
            loadWaitlist();
            $("#waitlistForm")[0].reset();
        });
    });

    // Load waitlist when page loads
    $(document).ready(loadWaitlist);
</script>

</body>
</html>
