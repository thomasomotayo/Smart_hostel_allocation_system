<?php
session_start();

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'hostel_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Base URL (define only once!)
define('BASE_URL', 'http://localhost/hostel/');

// Load helper functions – make sure this file exists and has no errors
require_once __DIR__ . '/functions.php';

// Paystack keys
define('PAYSTACK_SECRET_KEY', 'sk_test_f8e754c1ccdbd4116546bb0235bb428988578c2c');
define('PAYSTACK_PUBLIC_KEY', 'pk_test_7d1d01424f889542e452b6e164b85c2328f908bd');

// Hostel fee in Naira
define('HOSTEL_FEE', 50000);