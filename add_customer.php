<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO Customers (name, phone_number, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $phone_number, $email);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Customer added successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
