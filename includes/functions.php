<?php
require_once 'config.php';

// Get available room (first with occupancy < capacity)
function getAvailableRoom() {
    global $conn;
    $stmt = $conn->prepare("SELECT id, room_number FROM rooms WHERE occupied < capacity ORDER BY floor, room_number LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Check if student payment is verified
function isPaymentVerified($student_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT payment_status FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result && $result['payment_status'] == 'verified';
}

// Get student's active allocation
function getStudentAllocation($student_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT a.id AS allocation_id, r.room_number, r.floor, a.allocation_date
                           FROM allocations a
                           JOIN rooms r ON a.room_id = r.id
                           WHERE a.student_id = ? AND a.status = 'active'");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Allocate student to next available room
function allocateStudent($student_id) {
    global $conn;
    // Check if already allocated
    if (getStudentAllocation($student_id)) {
        return "already_allocated";
    }
    $room = getAvailableRoom();
    if (!$room) {
        return "no_room";
    }
    // Insert allocation
    $stmt = $conn->prepare("INSERT INTO allocations (student_id, room_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $student_id, $room['id']);
    if ($stmt->execute()) {
        // Update room occupancy
        $conn->query("UPDATE rooms SET occupied = occupied + 1 WHERE id = {$room['id']}");
        return $room['room_number'];
    }
    return false;
}

// Redirect if not logged in
function requireLogin($role = 'student') {
    if ($role == 'student' && !isset($_SESSION['student_id'])) {
        header("Location: ../login.php");
        exit();
    }
    if ($role == 'admin' && !isset($_SESSION['admin_id'])) {
        header("Location: ../login.php");
        exit();
    }
}
?>