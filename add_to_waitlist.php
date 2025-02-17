<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST["customer_id"];
    $restaurant_id = $_POST["restaurant_id"];

    $stmt = $conn->prepare("INSERT INTO waitlist (customer_id, restaurant_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $customer_id, $restaurant_id);

    if ($stmt->execute()) {
        echo "Added to waitlist!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
