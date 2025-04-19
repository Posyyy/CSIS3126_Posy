<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_id = $_POST['table_id'];

    // Mark table as occupied for now (you can expand this)
    $sql = "UPDATE tables SET status = 'occupied' WHERE table_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $table_id);
    if ($stmt->execute()) {
        echo "Table assigned successfully!";
    } else {
        echo "Error assigning table.";
    }
}
?>
