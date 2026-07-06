<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin('student');
$student_id = $_SESSION['student_id'];

$student = $conn->query("SELECT * FROM students WHERE id=$student_id")->fetch_assoc();
$allocation = getStudentAllocation($student_id);
include '../includes/header.php';
?>

<!-- Student Dashboard Hero -->
<div class="hero" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('../assets/images/hero-bg.jpg') center/cover; padding: 50px 0; margin-bottom: 30px;">
    <h1><i class="fas fa-tachometer-alt"></i> Student Dashboard</h1>
    <p class="lead">Manage your hostel booking and view allocation details.</p>
</div>

<div class="row">
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header text-center">
                <i class="fas fa-user-circle fa-3x mb-2"></i>
                <h5><?= htmlspecialchars($student['full_name']) ?></h5>
            </div>
            <div class="card-body">
                <p><i class="fas fa-id-card"></i> <strong>Student ID:</strong> <?= $student['student_id'] ?></p>
                <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                <p><i class="fas fa-phone"></i> <strong>Phone:</strong> <?= $student['phone'] ?></p>
                <hr>
                <p><strong>Payment Status:</strong> 
                    <span class="badge bg-<?= $student['payment_status']=='verified'?'success':'warning' ?>">
                        <?= ucfirst($student['payment_status']) ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Allocation & Actions Card -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h5><i class="fas fa-door-open"></i> Room Allocation</h5></div>
            <div class="card-body">
                <?php if($allocation): ?>
                    <div class="alert alert-success">
                        <h4><i class="fas fa-check-circle"></i> Room Allocated!</h4>
                        <p><strong>Room Number:</strong> <?= $allocation['room_number'] ?> (Floor <?= $allocation['floor'] ?>)</p>
                        <p><strong>Allocation Date:</strong> <?= $allocation['allocation_date'] ?></p>
                    </div>
                    <a href="allocation_slip.php?id=<?= $allocation['allocation_id'] ?>" class="btn btn-primary" target="_blank">
                        <i class="fas fa-print"></i> Print Allocation Slip
                    </a>
                    <a href="../availability.php" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-building"></i> View Room Availability
                    </a>
                <?php elseif(isPaymentVerified($student_id)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-bed fa-4x text-success mb-3"></i>
                        <h5>Your payment has been verified!</h5>
                        <p>You are now eligible to book a room.</p>
                        <a href="booking.php" class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle"></i> Book Your Room Now
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-credit-card fa-4x text-warning mb-3"></i>
                        <h5>Payment Pending</h5>
                        <p>You need to submit your payment proof before booking a room.</p>
                        <a href="../payment.php" class="btn btn-warning btn-lg">
                            <i class="fas fa-paper-plane"></i> Submit Payment Now
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Links Card -->
        <div class="card mt-4">
            <div class="card-header"><h5><i class="fas fa-link"></i> Quick Actions</h5></div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <a href="../payment.php" class="btn btn-outline-warning w-100 py-3">
                            <i class="fas fa-credit-card fa-2x d-block mb-1"></i> Payment
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="../availability.php" class="btn btn-outline-info w-100 py-3">
                            <i class="fas fa-building fa-2x d-block mb-1"></i> Room Availability
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="booking.php" class="btn btn-outline-success w-100 py-3">
                            <i class="fas fa-bed fa-2x d-block mb-1"></i> Book Room
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="../logout.php" class="btn btn-outline-danger w-100 py-3">
                            <i class="fas fa-sign-out-alt fa-2x d-block mb-1"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>