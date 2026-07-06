<?php
require_once 'includes/config.php';

echo '<h3>Debug Information</h3>';

// 1. Check if key is correctly defined
echo '<p><strong>Secret key length:</strong> ' . strlen(PAYSTACK_SECRET_KEY) . ' characters</p>';
echo '<p><strong>Secret key prefix:</strong> ' . substr(PAYSTACK_SECRET_KEY, 0, 7) . ' (should be "sk_test")</p>';

// 2. Check cURL availability
echo '<p><strong>cURL extension:</strong> ' . (function_exists('curl_init') ? '✅ Enabled' : '❌ Not enabled') . '</p>';

// 3. Check allow_url_fopen
echo '<p><strong>allow_url_fopen:</strong> ' . (ini_get('allow_url_fopen') ? '✅ Enabled' : '❌ Disabled') . '</p>';

// 4. Attempt cURL request to Paystack with a dummy reference
echo '<h3>cURL Test</h3>';
if (function_exists('curl_init')) {
    $reference = 'test-ref-123';
    $ch = curl_init('https://api.paystack.co/transaction/verify/' . rawurlencode($reference));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . PAYSTACK_SECRET_KEY,
        'Cache-Control: no-cache'
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    echo "<p>HTTP Code: $httpCode</p>";
    if ($curlError) {
        echo "<p style='color:red'>cURL Error: $curlError</p>";
    }
    echo '<pre>' . htmlspecialchars(print_r(json_decode($response, true), true)) . '</pre>';
} else {
    echo '<p style="color:red">cURL not available, skipping.</p>';
}

// 5. Attempt file_get_contents method
echo '<h3>file_get_contents Test</h3>';
if (ini_get('allow_url_fopen')) {
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Bearer " . PAYSTACK_SECRET_KEY . "\r\n" .
                        "Cache-Control: no-cache\r\n"
        ]
    ]);
    $response = @file_get_contents('https://api.paystack.co/transaction/verify/' . rawurlencode($reference), false, $context);
    if ($response === false) {
        echo '<p style="color:red">file_get_contents failed (check network or SSL).</p>';
    } else {
        echo '<pre>' . htmlspecialchars(print_r(json_decode($response, true), true)) . '</pre>';
    }
} else {
    echo '<p style="color:red">allow_url_fopen is off.</p>';
}