<?php
require_once '../includes/config.php';
header('Content-Type: application/json');
$rooms = $conn->query("SELECT room_number, floor, occupied, capacity FROM rooms ORDER BY floor, room_number");
$data = [];
while($row = $rooms->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>