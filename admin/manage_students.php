<?php
require_once '../includes/config.php';
requireLogin('admin');
$students = $conn->query("SELECT * FROM students");
include '../includes/header.php';
?>
<h2>Manage Students</h2>
<table class="table table-bordered">
    <thead><tr><th>ID</th><th>Student ID</th><th>Name</th><th>Email</th><th>Payment</th></tr></thead>
    <tbody>
    <?php while($row = $students->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['student_id'] ?></td>
        <td><?= htmlspecialchars($row['full_name']) ?></td>
        <td><?= $row['email'] ?></td>
        <td><span class="badge bg-<?= $row['payment_status']=='verified'?'success':'warning' ?>"><?= $row['payment_status'] ?></span></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>