<?php
require_once 'includes/config.php';

// --- 1. Get the reference from Paystack redirect ---
$reference = $_GET['reference'] ?? '';
if (empty($reference)) {
    die('<div style="color:red; padding:20px;">No reference supplied.</div>');
}

// --- 2. Verify that the secret key constant is available ---
if (!defined('PAYSTACK_SECRET_KEY') || strlen(PAYSTACK_SECRET_KEY) < 7) {
    die('<div style="color:red; padding:20px;">Paystack secret key is missing or invalid in config.php.</div>');
}

// --- 3. Fetch the student ID from the transactions table (safer) ---
$stmt = $conn->prepare("SELECT student_id FROM transactions WHERE reference = ?");
$stmt->bind_param("s", $reference);
$stmt->execute();
$trans = $stmt->get_result()->fetch_assoc();
if (!$trans) {
    die('<div style="color:red; padding:20px;">Transaction reference not found in database. This reference: ' . htmlspecialchars($reference) . '</div>');
}
$student_id = $trans['student_id'];

// --- 4. Verify with Paystack API using cURL ---
$url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . PAYSTACK_SECRET_KEY,
    'Cache-Control: no-cache',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// Debug – remove this after testing
// echo "<pre>HTTP Code: $httpCode\nResponse: $response</pre>"; exit;

if ($curlError) {
    die("cURL error: $curlError");
}

$result = json_decode($response, true);

// --- 5. Handle Paystack response ---
if (!$result['status']) {
    // Paystack returned an error (e.g. key invalid, reference not found)
    die('<div style="color:red; padding:20px;">'
        . '<h3>Payment verification failed</h3>'
        . '<p>Paystack says: ' . htmlspecialchars($result['message']) . '</p>'
        . '<a href="payment.php">Go back to payment</a>'
        . '</div>');
}

if ($result['data']['status'] === 'success') {
    // Update transaction status
    $stmt = $conn->prepare("UPDATE transactions SET status = 'success' WHERE reference = ?");
    $stmt->bind_param("s", $reference);
    $stmt->execute();

    // Mark student as verified
    $stmt = $conn->prepare("UPDATE students SET payment_status = 'verified', payment_ref = ?, payment_method = 'online' WHERE id = ?");
    $stmt->bind_param("si", $reference, $student_id);
    $stmt->execute();

    // Set session for the student (important!)
    $_SESSION['student_id'] = $student_id;

    // Redirect to dashboard
    header("Location: student/dashboard.php?payment=success");
    exit();
} else {
    echo '<div style="color:red; padding:20px;">'
        . '<h3>Payment not successful</h3>'
        . '<p>Status: ' . htmlspecialchars($result['data']['status']) . '</p>'
        . '<a href="payment.php">Try again</a>'
        . '</div>';
}