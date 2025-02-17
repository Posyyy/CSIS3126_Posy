<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $restaurant_id = $_POST['restaurant_id'];

    $stmt = $pdo->prepare("INSERT INTO waitlist (customer_id, restaurant_id, status) VALUES (?, ?, 'waiting')");

    if ($stmt->execute([$customer_id, $restaurant_id])) {
        echo json_encode(["success" => true, "message" => "Added to waitlist"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add"]);
    }
}
?>
