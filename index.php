<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Queue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Restaurant Waitlist</h1>

    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>Customer ID</th>
            <th>Name</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $result = $conn->query("SELECT w.customer_id, c.name, w.status
        FROM waitlist w
        JOIN customers c ON w.customer_id = c.customer_id");
        if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['customer_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['status']}</td>
        </tr>";
        }
        } else {
        echo "<tr><td colspan='3' class='text-center'>No customers in waitlist.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php $conn->close(); ?>
