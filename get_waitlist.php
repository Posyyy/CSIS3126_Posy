<?php
include 'db.php';

$sql = "SELECT Waitlist.waitlist_id, Customers.name, Customers.phone_number, Waitlist.party_size, Waitlist.status, Waitlist.arrival_time
        FROM Waitlist
        INNER JOIN Customers ON Waitlist.customer_id = Customers.customer_id
        ORDER BY Waitlist.arrival_time ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['waitlist_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . $row['party_size'] . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";

        // If user is admin, show remove button
        session_start();
        if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
            echo "<td><button class='btn btn-danger btn-sm' onclick='removeFromWaitlist(" . $row['waitlist_id'] . ")'>Remove</button></td>";
        }

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>No customers in the waitlist.</td></tr>";
}

$conn->close();
?>
