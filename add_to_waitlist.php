<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];
    $restaurant_id = $_POST["restaurant_id"];
    $party_size = $_POST["party_size"];

    // Check if customer already exists by email
    $checkStmt = $conn->prepare("SELECT customer_id FROM customers WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $checkStmt->bind_result($customer_id);
        $checkStmt->fetch();
    } else {
        // Insert new customer
        $insertStmt = $conn->prepare("INSERT INTO customers (name, phone_number, email) VALUES (?, ?, ?)");
        $insertStmt->bind_param("sss", $name, $phone_number, $email);
        if ($insertStmt->execute()) {
            $customer_id = $insertStmt->insert_id; // Get the new customer ID
        } else {
            echo "Error adding customer: " . $conn->error;
            exit;
        }
        $insertStmt->close();
    }
    $checkStmt->close();

    // Insert into waitlist
    $stmt = $conn->prepare("INSERT INTO waitlist (customer_id, restaurant_id, party_size, status, arrival_time) VALUES (?, ?, ?, 'Waiting', NOW())");
    $stmt->bind_param("iii", $customer_id, $restaurant_id, $party_size);

    if ($stmt->execute()) {
        echo "Added to waitlist!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
