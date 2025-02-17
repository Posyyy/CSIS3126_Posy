<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $waitlist_id = $_POST['waitlist_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE waitlist SET status = ? WHERE waitlist_id = ?");

    if ($stmt->execute([$status, $waitlist_id])) {
        echo json_encode(["success" => true, "message" => "Status updated"]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed"]);
    }
}
?>
