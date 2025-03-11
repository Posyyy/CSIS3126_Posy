<?php
session_start();
include 'db.php';

$restaurant_id = 5; // Replace this dynamically if needed

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Queue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Join the Waitlist</h2>
    <form id="waitlistForm" method="POST" action="add_to_waitlist.php">
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

        <!-- Time Picker for Reservations (Initially Hidden) -->
        <div class="mb-3" id="reservation_time_container" style="display: none;">
            <label for="reservation_time" class="form-label">Reservation Time</label>
            <input type="time" class="form-control" name="reservation_time" id="reservation_time">
        </div>

        <button type="submit" class="btn btn-primary">Join Waitlist</button>
    </form>
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
</script>

</body>
</html>
