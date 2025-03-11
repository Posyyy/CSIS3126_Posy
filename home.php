<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];
    $restaurant_id = $_POST["restaurant_id"];
    $party_size = $_POST["party_size"];
    $waitlist_type = $_POST["waitlist_type"];

    // Check if customer already exists based on email or phone number
    $checkStmt = $conn->prepare("SELECT customer_id FROM customers WHERE email = ? OR phone_number = ?");
    $checkStmt->bind_param("ss", $email, $phone_number);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Customer exists, fetch customer ID
        $checkStmt->bind_result($customer_id);
        $checkStmt->fetch();
    } else {
        // Customer doesn't exist, insert into customers table
        $insertStmt = $conn->prepare("INSERT INTO customers (name, phone_number, email) VALUES (?, ?, ?)");
        $insertStmt->bind_param("sss", $name, $phone_number, $email);
        if ($insertStmt->execute()) {
            $customer_id = $insertStmt->insert_id; // Get the newly inserted customer ID
        } else {
            echo "Error: " . $conn->error;
            exit();
        }
        $insertStmt->close();
    }
    $checkStmt->close();

    // Insert into waitlist
    $stmt = $conn->prepare("INSERT INTO waitlist (customer_id, restaurant_id, party_size, waitlist_type, status, arrival_time) VALUES (?, ?, ?, ?, 'Waiting', NOW())");
    $stmt->bind_param("iiss", $customer_id, $restaurant_id, $party_size, $waitlist_type);

    if ($stmt->execute()) {
        echo "Successfully added to waitlist!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
