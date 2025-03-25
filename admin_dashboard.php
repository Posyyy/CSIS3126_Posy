<?php
session_start();

// Redirect non-admin users to home
//if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
  //  header("Location: index.html");
   // exit();
//}

include 'db.php'; // Ensure this file correctly establishes the database connection

// Fetch waitlist data
$sql = "SELECT Waitlist.waitlist_id, Customers.name, Customers.phone_number, Waitlist.party_size, Waitlist.status
        FROM Waitlist
        INNER JOIN Customers ON Waitlist.customer_id = Customers.customer_id
        ORDER BY Waitlist.waitlist_id ASC";

$result = $conn->query($sql);

$waitlist = [];
while ($row = $result->fetch_assoc()) {
    $waitlist[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="d-flex flex-column align-items-center p-4">

    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="card p-4 shadow-lg" style="width: 80%;">
        <h4>Waitlist Management</h4>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Phone Number</th>
                    <th>Party Size</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($waitlist as $entry): ?>
                <tr>
                    <td><?php echo $entry['waitlist_id']; ?></td>
                    <td><?php echo htmlspecialchars($entry['name']); ?></td>
                    <td><?php echo htmlspecialchars($entry['phone_number']); ?></td>
                    <td><?php echo $entry['party_size']; ?></td>
                    <td id="status-<?php echo $entry['waitlist_id']; ?>"><?php echo ucfirst($entry['status']); ?></td>
                    <td>
                        <button onclick="updateStatus(<?php echo $entry['waitlist_id']; ?>, 'Seated')" class="btn btn-success btn-sm">Seat</button>
                        <button onclick="updateStatus(<?php echo $entry['waitlist_id']; ?>, 'Removed')" class="btn btn-danger btn-sm">Remove</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="home.php" class="btn btn-secondary mt-3">Back to Home</a>
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>

    <script>
        function updateStatus(id, newStatus) {
            if (confirm("Are you sure you want to update the status to " + newStatus + "?")) {
                $.post("update_status.php", { id: id, status: newStatus }, function(response) {
                    alert(response);
                    $("#status-" + id).text(newStatus); // Update status in UI
                });
            }
        }
    </script>

</body>
</html>
