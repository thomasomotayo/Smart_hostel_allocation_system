<?php
require_once '../includes/config.php';
requireLogin('admin');
if(isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE students SET payment_status='verified' WHERE id=$id");
    header("Location: verify_payments.php");
    exit();
}
$students = $conn->query("SELECT * FROM students WHERE payment_status='pending'");
include '../includes/header.php';
?>
<h2>Pending Payment Verifications</h2>
<table class="table table-bordered">
    <thead><tr><th>ID</th><th>Student ID</th><th>Name</th><th>Ref</th><th>Proof</th><th>Action</th></tr></thead>
    <tbody>
    <?php while($row = $students->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['student_id'] ?></td>
        <td><?= htmlspecialchars($row['full_name']) ?></td>
        <td><?= $row['payment_ref'] ?></td>
        <td><a href="<?= BASE_URL . $row['payment_proof'] ?>" target="_blank">View</a></td>
        <td><a href="?approve=<?= $row['id'] ?>" class="btn btn-sm btn-success">Approve</a></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>