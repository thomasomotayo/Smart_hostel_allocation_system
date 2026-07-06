<?php
require_once 'includes/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $full_name  = $_POST['full_name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO students (student_id, full_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $student_id, $full_name, $email, $phone, $password);
    if ($stmt->execute()) {
        $_SESSION['student_id'] = $conn->insert_id;
        header("Location: payment.php");
        exit();
    } else {
        $error = "Registration failed! Student ID or Email may already exist.";
    }
}
include 'includes/header.php';
?>

<!-- Hero section for register -->
<div class="hero" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/images/hero-bg.jpg') center/cover; padding: 60px 0; margin-bottom: 30px;">
    <h1><i class="fas fa-user-plus"></i> Student Registration</h1>
    <p class="lead">Join the hostel community and book your room in minutes.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-user-graduate"></i> Create Your Account</h4>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-id-card"></i> Student ID / Roll No</label>
                        <input type="text" name="student_id" class="form-control" placeholder="e.g. STU2024001" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user"></i> Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-phone"></i> Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="+234..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane"></i> Register</button>
                </form>
                <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>