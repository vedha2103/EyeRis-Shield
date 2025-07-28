<?php
session_start();
header('Content-Type: application/json');

require_once 'config/db.php'; // Make sure this connects correctly

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// Check if required data is sent
if (!$data || empty($data['test_type']) || empty($data['result'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing test data.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$test_type = $data['test_type'];
$result = $data['result'];
$notes = isset($data['notes']) ? $data['notes'] : '';
$test_date = date('Y-m-d H:i:s');

// Prepare the query
$stmt = $conn->prepare("INSERT INTO eye_test_records (user_id, test_type, result, test_date, notes) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("issss", $user_id, $test_type, $result, $test_date, $notes);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Result saved successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Execute failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
