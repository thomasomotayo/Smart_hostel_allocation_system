<?php
require_once '../includes/config.php';
requireLogin('admin');
// Occupancy report
$occupancy = $conn->query("SELECT floor, room_number, occupied, capacity FROM rooms ORDER BY floor, room_number");
$total_capacity = $conn->query("SELECT SUM(capacity) as total FROM rooms")->fetch_assoc()['total'];
$total_occupied = $conn->query("SELECT SUM(occupied) as total FROM rooms")->fetch_assoc()['total'];
include '../includes/header.php';
?>
<h2>Reports</h2>
<h4>Room Occupancy Summary</h4>
<p>Total Capacity: <?= $total_capacity ?>, Occupied: <?= $total_occupied ?>, Available: <?= $total_capacity - $total_occupied ?></p>
<table class="table table-striped">
    <thead><tr><th>Floor</th><th>Room</th><th>Occupied</th><th>Capacity</th><th>Available</th></tr></thead>
    <tbody>
    <?php while($row = $occupancy->fetch_assoc()): ?>
    <tr>
        <td><?= $row['floor'] ?></td>
        <td><?= $row['room_number'] ?></td>
        <td><?= $row['occupied'] ?></td>
        <td><?= $row['capacity'] ?></td>
        <td><?= $row['capacity'] - $row['occupied'] ?></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>