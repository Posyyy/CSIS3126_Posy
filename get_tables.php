<?php
include 'db.php';

$restaurant_id = $_GET['restaurant_id'] ?? 1;

$sql = "SELECT * FROM tables WHERE restaurant_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $restaurant_id);
$stmt->execute();
$result = $stmt->get_result();

$tables = [];
while ($row = $result->fetch_assoc()) {
    $tables[] = $row;
}

header('Content-Type: application/json'); // Ensure proper content type
echo json_encode($tables);
?>
