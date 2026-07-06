<?php
require_once '../includes/config.php';
requireLogin('admin');
$allocations = $conn->query("SELECT a.id, s.student_id, s.full_name, r.room_number, r.floor, a.allocation_date
                             FROM allocations a
                             JOIN students s ON a.student_id = s.id
                             JOIN rooms r ON a.room_id = r.id
                             WHERE a.status='active'
                             ORDER BY r.floor, r.room_number");
include '../includes/header.php';
?>
<h2>All Room Allocations</h2>
<table class="table table-striped">
    <thead><tr><th>Allocation ID</th><th>Student ID</th><th>Name</th><th>Room</th><th>Floor</th><th>Date</th><th>Slip</th></tr></thead>
    <tbody>
    <?php while($row = $allocations->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['student_id'] ?></td>
        <td><?= htmlspecialchars($row['full_name']) ?></td>
        <td><?= $row['room_number'] ?></td>
        <td><?= $row['floor'] ?></td>
        <td><?= $row['allocation_date'] ?></td>
        <td><a href="generate_slip.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-sm btn-primary">Print</a></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>