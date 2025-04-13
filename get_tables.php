<?php
include 'db.php';

$sql = "SELECT * FROM Tables ORDER BY table_number ASC";
$result = $conn->query($sql);

$tables = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tables[] = $row;
    }
}

echo json_encode($tables); // Send JSON to the frontend
$conn->close();
?>
