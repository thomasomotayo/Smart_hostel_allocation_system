<?php
require_once 'includes/config.php';
require_once 'vendor/autoload.php';  // loads PHPMailer + Paystack libs

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id, full_name FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($student = $result->fetch_assoc()) {
        // Generate secure token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store token in database
        $stmt = $conn->prepare("INSERT INTO password_resets (student_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $student['id'], $token, $expires);
        $stmt->execute();

        // Build reset link
        $reset_link = BASE_URL . "reset_password.php?token=" . $token;

        // ---- Send email using PHPMailer ----
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration – adjust for your email provider
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';          // Gmail SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'thomasomotayo@gmail.com';    // Your full Gmail address
            $mail->Password   = 'xzkm vkdp sjde lhli';       // Gmail App Password (not your normal password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('your_email@gmail.com', 'Hostel Allocation System');
            $mail->addAddress($email, $student['full_name']);  // Student's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset - Hostel Allocation';
            $mail->Body    = "
                <h2>Password Reset Request</h2>
                <p>Hello {$student['full_name']},</p>
                <p>We received a request to reset your password. Click the link below to set a new password (valid for 1 hour):</p>
                <p><a href='{$reset_link}' style='display:inline-block;padding:10px 20px;background:#1e3c72;color:#fff;border-radius:5px;text-decoration:none;'>Reset Password</a></p>
                <p>Or copy and paste this link: <br>{$reset_link}</p>
                <p>If you didn't request this, please ignore this email.</p>
            ";

            $mail->send();
            $msg = "A password reset link has been sent to your email. Please check your inbox (and spam folder).";
        } catch (Exception $e) {
            // If email fails, log the error but still show a generic message (don’t leak token)
            error_log("Password reset email failed: " . $mail->ErrorInfo);
            $error = "We could not send the reset email at this moment. Please try again later or contact support.";
        }
    } else {
        // Don't reveal whether the email exists – generic message for security
        $msg = "If that email is registered, a password reset link has been sent.";
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header text-center"><h4><i class="fas fa-unlock-alt"></i> Forgot Password</h4></div>
            <div class="card-body">
                <?php if($msg): ?>
                    <div class="alert alert-success"><?= $msg ?></div>
                <?php endif; ?>
                <?php if($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label><i class="fas fa-envelope"></i> Enter your registered email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane"></i> Send Reset Link</button>
                </form>
                <p class="text-center mt-3"><a href="login.php">Back to Login</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>