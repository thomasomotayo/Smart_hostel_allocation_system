<?php
require_once 'includes/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $type = $_POST['type'] ?? 'student';
    
    if ($type == 'admin') {
        $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['admin_id'] = $result['id'];
            header("Location: admin/dashboard.php");
            exit();
        }
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM students WHERE student_id = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['student_id'] = $result['id'];
            $stmt2 = $conn->prepare("SELECT payment_status FROM students WHERE id = ?");
            $stmt2->bind_param("i", $_SESSION['student_id']);
            $stmt2->execute();
            $status = $stmt2->get_result()->fetch_assoc()['payment_status'];
            if ($status == 'pending') {
                header("Location: payment.php");
            } else {
                header("Location: student/dashboard.php");
            }
            exit();
        }
    }
    $error = "Invalid credentials!";
}
include 'includes/header.php';
?>

<div class="hero" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/images/hero-bg.jpg') center/cover; padding: 60px 0; margin-bottom: 30px;">
    <h1><i class="fas fa-sign-in-alt"></i> Welcome Back</h1>
    <p class="lead">Login to your hostel management account.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-lock"></i> Sign In</h4>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user"></i> Username / Student ID / Email</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter your credentials" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-key"></i> Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Login as</label>
                        <select name="type" class="form-select">
                            <option value="student"><i class="fas fa-user-graduate"></i> Student</option>
                            <option value="admin"><i class="fas fa-user-shield"></i> Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-sign-in-alt"></i> Login</button>
                </form>
                <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
                <div class="text-end mt-2">
                 <a href="forgot_password.php">Forgot password?</a>
            </div>
            </div>
            
        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>