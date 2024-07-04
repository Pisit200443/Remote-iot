<?php

session_start();
require_once('../server.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $content = file_get_contents("php://input");
    $data = json_decode($content, true);

    $device_id = $data['device_id'] ?? '';
    $date = $data['date'] ?? '';
    $time = $data['time'] ?? '';
    $button = $data['remote_button'] ?? '';

    if (empty($device_id) || empty($date) || empty($time) || empty($button)) {
        // $_SESSION['error_message'] = "Place add data!";
        header("location: ../remote_control.php?device_id=$device_id");
        exit;
    }

    $date_time = $date . ' ' . $time;

    $stmt = $conn->prepare("SELECT date_time FROM schedule WHERE device_id = :device_id");
    $stmt->bindParam(":device_id", $device_id);
    $stmt->execute();
    $dateTime_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dateTime_row !== false && $dateTime_row['date_time'] === $date_time) {
        // $_SESSION['error_message'] = "เวลานี้ได้มีการบันทึกไว้แล้ว โปรดเลือกเวลาใหม่";
        header("location: ../remote_control.php?device_id=$device_id");
        exit;
    } else {
        $stmt = $conn->prepare("INSERT INTO schedule (date_time, value, device_id, status) VALUES (:date_time, :remote_button, :device_id, '1')");
        $stmt->bindParam(":device_id", $device_id);
        $stmt->bindParam(":remote_button", $button);
        $stmt->bindParam(":date_time", $date_time);
        $stmt->execute();
        header("location: ../remote_control.php?device_id=$device_id");
        exit;
    }
}

?>
