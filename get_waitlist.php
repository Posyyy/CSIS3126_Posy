<?php
session_start();
include 'db.php';

$restaurant_id = $_SESSION['restaurant_id'] ?? 1;

$sql = "SELECT waitlist.waitlist_id, customers.name, customers.email, waitlist.party_size, waitlist.status,
               waitlist.arrival_time, waitlist.waitlist_type, waitlist.reservation_time
        FROM waitlist
        INNER JOIN customers ON waitlist.customer_id = customers.customer_id
        WHERE waitlist.restaurant_id = ? AND waitlist.status != 'Removed'
        ORDER BY waitlist.arrival_time ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $restaurant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['waitlist_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . $row['party_size'] . "</td>";
        echo "<td>" . htmlspecialchars($row['waitlist_type']) . "</td>";
        echo "<td>" . ($row['reservation_time'] ?? 'N/A') . "</td>";
        echo "<td id='status-{$row['waitlist_id']}'>" . htmlspecialchars($row['status']) . "</td>";

        if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
            echo "<td>
                    <button class='btn btn-success btn-sm' onclick='updateStatus(" . $row['waitlist_id'] . ", \"Seated\")'>Seat</button>
                    <button class='btn btn-danger btn-sm' onclick='updateStatus(" . $row['waitlist_id'] . ", \"Removed\")'>Remove</button>
                  </td>";
        }

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7' class='text-center'>No customers in the waitlist.</td></tr>";
}

$stmt->close();
$conn->close();
?>
