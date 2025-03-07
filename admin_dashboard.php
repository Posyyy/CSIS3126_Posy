<?php
session_start();

// Redirect non-admin users to home
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: home.php");
    exit();
}

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
                    <td><?php echo ucfirst($entry['status']); ?></td>
                    <td>
                        <a href="update_status.php?id=<?php echo $entry['waitlist_id']; ?>&status=seated" class="btn btn-success btn-sm">Seat</a>
                        <a href="update_status.php?id=<?php echo $entry['waitlist_id']; ?>&status=removed" class="btn btn-danger btn-sm">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="home.php" class="btn btn-secondary mt-3">Back to Home</a>
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>

</body>
</html>
