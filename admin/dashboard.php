<?php
require_once '../includes/config.php';
requireLogin('admin');
$total_students = $conn->query("SELECT COUNT(*) as cnt FROM students")->fetch_assoc()['cnt'];
$total_rooms = $conn->query("SELECT COUNT(*) as cnt FROM rooms")->fetch_assoc()['cnt'];
$allocated = $conn->query("SELECT COUNT(*) as cnt FROM allocations WHERE status='active'")->fetch_assoc()['cnt'];
$pending_payments = $conn->query("SELECT COUNT(*) as cnt FROM students WHERE payment_status='pending'")->fetch_assoc()['cnt'];
include '../includes/header.php';
?>

<h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-stat" style="background: linear-gradient(45deg, #4facfe, #00f2fe);">
            <div><i class="fas fa-users"></i></div>
            <div><h3><?= $total_students ?></h3><small>Total Students</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-stat" style="background: linear-gradient(45deg, #43e97b, #38f9d7);">
            <div><i class="fas fa-door-open"></i></div>
            <div><h3><?= $total_rooms ?></h3><small>Total Rooms</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-stat" style="background: linear-gradient(45deg, #fa709a, #fee140);">
            <div><i class="fas fa-check-circle"></i></div>
            <div><h3><?= $allocated ?></h3><small>Allocated</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-stat" style="background: linear-gradient(45deg, #f093fb, #f5576c);">
            <div><i class="fas fa-clock"></i></div>
            <div><h3><?= $pending_payments ?></h3><small>Pending Payments</small></div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header"><i class="fas fa-cogs"></i> Quick Actions</div>
    <div class="card-body">
        <a href="verify_payments.php" class="btn btn-warning me-2"><i class="fas fa-check-circle"></i> Verify Payments</a>
        <a href="allocations.php" class="btn btn-info me-2"><i class="fas fa-list-ul"></i> View Allocations</a>
        <a href="reports.php" class="btn btn-secondary me-2"><i class="fas fa-chart-bar"></i> Reports</a>
        <a href="manage_students.php" class="btn btn-dark"><i class="fas fa-user-cog"></i> Manage Students</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>