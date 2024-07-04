<?php
session_start();
require_once('../server.php');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(["message" => "Invalid request. Use GET method."]);
    exit();
}

$devicename = $_GET['device_name'] ?? '';
$DateData = array();

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
    $stmt = $conn->prepare("SELECT * FROM schedule WHERE device_id = :device_id AND status = '1' ORDER BY date_time ASC LIMIT 1");
    $stmt->bindParam(":device_id", $device['device_id']);
    $stmt->execute();
    $timeResults = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($timeResults) {
    // Date now
    date_default_timezone_set('Asia/Bangkok');  // กำหนด timezone
    $TimeNow = time();  // timestamp ปัจจุบัน
   
    // Set date to DB 
    $DB_Time = $timeResults['date_time'];
    $set_DB_Time = strtotime($DB_Time);
    
    if ($set_DB_Time <= $TimeNow) {
        echo $timeResults['value'];

        // Update status
        $sd_id = $timeResults['sd_id']; 
        $stmt = $conn->prepare("UPDATE schedule SET status = '0' WHERE device_id = :device_id AND sd_id = :sd_id");
        $stmt->bindParam(":device_id", $device['device_id']);
        $stmt->bindParam(":sd_id", $sd_id);
        $stmt->execute();
        exit;
    }

} else {
    echo json_encode(["message" => "No information found."]);
}
?>
