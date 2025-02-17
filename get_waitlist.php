<?php
include 'db.php';

$sql = "SELECT Waitlist.waitlist_id, Customers.name, Customers.phone_number, Waitlist.party_size, Waitlist.status, Waitlist.arrival_time
        FROM Waitlist
        INNER JOIN Customers ON Waitlist.customer_id = Customers.customer_id
        ORDER BY Waitlist.arrival_time ASC";

$result = $conn->query($sql);

$waitlist =  [];

while ($row = $result->fetch_assoc()) {
    $waitlist[] = $row;
}

echo json_encode($waitlist);

$conn->close();
?>
