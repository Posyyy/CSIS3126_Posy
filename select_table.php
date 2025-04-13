<?php
include 'db.php';

if (isset($_POST['table_id'])) {
    $table_id = $_POST['table_id'];

    $sql = "UPDATE Tables SET status = 'Occupied' WHERE table_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $table_id);
        if ($stmt->execute()) {
            echo "Table selected successfully.";
        } else {
            echo "Failed to update table.";
        }
        $stmt->close();
    } else {
        echo "Database error: Could not prepare statement.";
    }
} else {
    echo "No table ID provided.";
}

$conn->close();
?>
