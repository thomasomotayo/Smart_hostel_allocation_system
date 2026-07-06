<?php
require_once 'includes/config.php';
if (!isset($_SESSION['student_id'])) { header("Location: login.php"); exit(); }
$student_id = $_SESSION['student_id'];

// ---- Handle receipt upload ----
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_type']) && $_POST['payment_type'] == 'receipt') {
    $ref = $_POST['payment_ref'];
    $proof = '';
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == 0) {
        $ext = pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION);
        $proof = 'uploads/' . time() . '_' . $student_id . '.' . $ext;
        move_uploaded_file($_FILES['payment_proof']['tmp_name'], $proof);
    }
    $stmt = $conn->prepare("UPDATE students SET payment_ref=?, payment_proof=?, payment_method='receipt', payment_status='pending' WHERE id=?");
    $stmt->bind_param("ssi", $ref, $proof, $student_id);
    $stmt->execute();
    $msg = "Payment details submitted. Wait for admin verification.";
}

// ---- Handle Paystack online payment ----
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_type']) && $_POST['payment_type'] == 'paystack') {
    $reference = 'HOSTEL-' . time() . '-' . $student_id;
    $amount = HOSTEL_FEE * 100;

    // Insert pending transaction
    $stmt = $conn->prepare("INSERT INTO transactions (student_id, reference, amount, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("iss", $student_id, $reference, $amount);
    $stmt->execute();

    // Get student email
    $emailQuery = $conn->query("SELECT email FROM students WHERE id = $student_id");
    $email = $emailQuery->fetch_assoc()['email'];

    $callback_url = BASE_URL . 'paystack_callback.php';
    $paystack_url = "https://api.paystack.co/transaction/initialize";

    $fields = [
        'email' => $email,
        'amount' => $amount,
        'reference' => $reference,
        'callback_url' => $callback_url
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $paystack_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . PAYSTACK_SECRET_KEY,
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        die("cURL Error: $curlError");
    }

    $result = json_decode($response, true);

    if (!$result['status']) {
        die("Payment initialization failed: " . $result['message']);
    }

    header("Location: " . $result['data']['authorization_url']);
    exit();
}

// Fetch current payment status for display
$stmt = $conn->prepare("SELECT payment_status FROM students WHERE id=?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$status = $stmt->get_result()->fetch_assoc()['payment_status'];

include 'includes/header.php';
?>

<div class="hero" style="padding: 50px 0; margin-bottom: 30px;">
    <h1><i class="fas fa-credit-card"></i> Payment Verification</h1>
    <p class="lead">Choose your preferred payment method. Hostel fee: <strong>₦<?= number_format(HOSTEL_FEE) ?></strong></p>
</div>

<?php if(isset($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>

<?php if($status == 'verified'): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> Your payment is verified. 
        <a href="student/dashboard.php" class="alert-link">Go to Dashboard</a> to book your room.
    </div>
<?php else: ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="paymentTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="receipt-tab" data-bs-toggle="tab" href="#receipt" role="tab"><i class="fas fa-upload"></i> Upload Receipt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="paystack-tab" data-bs-toggle="tab" href="#paystack" role="tab"><i class="fas fa-globe"></i> Pay Online (Paystack)</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Receipt Upload Tab -->
                        <div class="tab-pane fade show active" id="receipt" role="tabpanel">
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="payment_type" value="receipt">
                                <div class="mb-3">
                                    <label><i class="fas fa-receipt"></i> Transaction Reference</label>
                                    <input type="text" name="payment_ref" class="form-control" placeholder="e.g. TXN123456" required>
                                </div>
                                <div class="mb-3">
                                    <label><i class="fas fa-file-image"></i> Upload Payment Proof (screenshot/PDF)</label>
                                    <input type="file" name="payment_proof" class="form-control" accept="image/*,.pdf" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane"></i> Submit for Verification</button>
                            </form>
                            <p class="text-muted mt-2 small">Admin will verify your payment manually.</p>
                        </div>

                        <!-- Paystack Online Payment Tab -->
                        <div class="tab-pane fade" id="paystack" role="tabpanel">
                            <div class="text-center py-4">
                                <img src="https://paystack.com/img/paystack-logo.png" alt="Paystack" width="150" class="mb-3">
                                <h5>Pay Instantly with Paystack</h5>
                                <p>Secure payment via card, bank, or USSD.</p>
                                <p class="text-muted">Amount: <strong>₦<?= number_format(HOSTEL_FEE) ?></strong></p>
                                <form method="post">
                                    <input type="hidden" name="payment_type" value="paystack">
                                    <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-check-circle"></i> Pay Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>