<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];

    $stmt = $conn->prepare("DELETE FROM Customers WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Customer deleted"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
