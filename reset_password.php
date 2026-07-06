<?php
require_once 'includes/config.php';
$token = $_GET['token'] ?? '';
$error = '';
$success = '';

if (empty($token)) {
    die("Invalid request.");
}

// Validate token
$stmt = $conn->prepare("SELECT student_id, expires_at, used FROM password_resets WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$reset = $stmt->get_result()->fetch_assoc();

if (!$reset || $reset['used'] || strtotime($reset['expires_at']) < time()) {
    $error = "This reset link is invalid or has expired.";
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // Update student password
    $stmt = $conn->prepare("UPDATE students SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $password, $reset['student_id']);
    $stmt->execute();
    // Mark token as used
    $conn->query("UPDATE password_resets SET used = 1 WHERE token = '$token'");
    $success = "Your password has been reset. <a href='login.php'>Login here</a>.";
}

include 'includes/header.php';
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header text-center"><h4><i class="fas fa-key"></i> Reset Password</h4></div>
            <div class="card-body">
                <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
                <?php if (!$error && !$success): ?>
                <form method="post">
                    <div class="mb-3">
                        <label><i class="fas fa-lock"></i> New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter new password" required minlength="6">
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="fas fa-check-circle"></i> Reset Password</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>