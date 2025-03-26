<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];
    $party_size = $_POST["party_size"];
    $waitlist_type = $_POST["waitlist_type"];
    $reservation_time = ($waitlist_type == "Reservation") ? $_POST["reservation_time"] : NULL;

    // Check if the customer already exists
    $stmt = $conn->prepare("SELECT customer_id FROM Customers WHERE phone_number = ?");
    $stmt->bind_param("s", $phone_number);
    $stmt->execute();
    $stmt->bind_result($customer_id);
    $stmt->fetch();
    $stmt->close();

    // If customer does not exist, insert new customer
    if (!$customer_id) {
        $stmt = $conn->prepare("INSERT INTO Customers (name, phone_number, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $phone_number, $email);
        $stmt->execute();
        $customer_id = $stmt->insert_id; // Get the new customer ID
        $stmt->close();
    }

    // Insert into waitlist (restaurant_id will default to 1 in MySQL)
    $stmt = $conn->prepare("INSERT INTO Waitlist (customer_id, party_size, status, waitlist_type, reservation_time, arrival_time)
                            VALUES (?, ?, 'Waiting', ?, ?, NOW())");
    $stmt->bind_param("iiss", $customer_id, $party_size, $waitlist_type, $reservation_time);

    if ($stmt->execute()) {
        echo "Added to waitlist!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
