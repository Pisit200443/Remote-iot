<?php
session_start();
require_once('../config/server.php');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(["message" => "Invalid request. Use GET method."]);
    exit();
}

$devicename = $_GET['device_name'] ?? '';
$valueArray = array();

if (empty($devicename)) {
    echo json_encode(["message" => "Invalid device name. Please provide required parameters."]);
    exit();
}

// Get device condition device name request
$stmt = $conn->prepare("SELECT device_id FROM device WHERE device_name = :device_name");
$stmt->bindParam(":device_name", $devicename);
$stmt->execute();
$device = $stmt->fetch(PDO::FETCH_ASSOC);

// Chack device name 
if (!$device) {
    echo json_encode(["message" => "Device name not found."]);
    exit();
} else {
    $stmt = $conn->prepare("SELECT value, status FROM real_time WHERE device_id = :device_id");
    $stmt->bindParam(":device_id", $device['device_id']);
    $stmt->execute();
    $valueResult = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Check status
if ($valueResult && $valueResult['status'] == 1) {
    echo $valueResult['value'];

    // Update status to remote real time.
    $stmt = $conn->prepare("UPDATE real_time set status = '0' WHERE device_id = :device_id");
    $stmt->bindParam(":device_id", $device['device_id']);
    $stmt->execute();
    exit;
} else {
    echo json_encode(["message" => "No button pressing."]);
}

?>
