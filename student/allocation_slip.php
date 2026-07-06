<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
if(!isset($_GET['id'])) die("Invalid request.");
$allocation_id = $_GET['id'];
// Fetch allocation details
$stmt = $conn->prepare("SELECT a.*, s.full_name, s.student_id as sid, s.email, r.room_number, r.floor
                       FROM allocations a
                       JOIN students s ON a.student_id = s.id
                       JOIN rooms r ON a.room_id = r.id
                       WHERE a.id = ?");
$stmt->bind_param("i", $allocation_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if(!$data) die("Allocation not found.");

// Create a QR code data string (JSON for easy scanning)
$qrData = json_encode([
    'allocation_id' => $data['id'],
    'student_id'    => $data['sid'],
    'student_name'  => $data['full_name'],
    'room'          => $data['room_number'],
    'floor'         => $data['floor'],
    'date'          => $data['allocation_date']
]);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Allocation Slip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print { .no-print { display: none; } }
        #qrcode { margin: 15px auto; text-align: center; }
        #qrcode img { margin: 0 auto; }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header text-center"><h3>Hostel Allocation Slip</h3></div>
        <div class="card-body">
            <p><strong>Student Name:</strong> <?= htmlspecialchars($data['full_name']) ?></p>
            <p><strong>Student ID:</strong> <?= $data['sid'] ?></p>
            <p><strong>Room Number:</strong> <?= $data['room_number'] ?> (Floor <?= $data['floor'] ?>)</p>
            <p><strong>Allocation Date:</strong> <?= $data['allocation_date'] ?></p>
            
            <!-- QR Code -->
            <div id="qrcode"></div>
            <p class="text-muted text-center"><small>Scan to verify allocation</small></p>
            
            <p class="mt-4"><em>This is a computer-generated slip.</em></p>
        </div>
    </div>
    <button class="btn btn-primary no-print mt-3" onclick="window.print()">Print Slip</button>
    <a href="dashboard.php" class="btn btn-secondary no-print mt-3">Back</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
    // Generate QR code with the allocation data
    new QRCode(document.getElementById("qrcode"), {
        text: <?= json_encode($qrData) ?>,
        width: 128,
        height: 128,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
</script>
</body>
</html>