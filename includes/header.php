<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Hostel Allocation System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= BASE_URL ?>">
      <img src="<?= BASE_URL ?>assets/images/logo.png" alt="Logo" onerror="this.style.display='none'">
      <span>OWUTECH Hostel</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['student_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>student/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>availability.php"><i class="fas fa-building"></i> Rooms</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        <?php elseif(isset($_SESSION['admin_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Admin Panel</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/allocations.php"><i class="fas fa-list-ul"></i> Allocations</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>register.php"><i class="fas fa-user-plus"></i> Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">