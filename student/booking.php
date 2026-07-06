<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin('student');
$student_id = $_SESSION['student_id'];

if (!isPaymentVerified($student_id)) {
    header("Location: ../payment.php");
    exit();
}
$result = allocateStudent($student_id);
include '../includes/header.php';
?>
<h2>Room Booking</h2>
<?php if($result == 'already_allocated'): ?>
    <div class="alert alert-info">You already have a room allocated. <a href="dashboard.php">Go to Dashboard</a></div>
<?php elseif($result == 'no_room'): ?>
    <div class="alert alert-danger">Sorry, no rooms available at the moment. Please contact admin.</div>
<?php elseif($result): ?>
    <div class="alert alert-success">Congratulations! You have been allocated Room <?= $result ?>.</div>
    <a href="dashboard.php" class="btn btn-primary">View Details</a>
<?php else: ?>
    <div class="alert alert-danger">Allocation failed. Please try again or contact admin.</div>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>