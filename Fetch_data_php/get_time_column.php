<?php
session_start();
require_once('../server.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $content = file_get_contents("php://input");
    $data = json_decode($content, true);

    $device_id = $data['device_id'] ?? '';
    $date = $data['date'] ?? '';
    $resultArray = array();

    $stmt = $conn->prepare("SELECT * FROM schedule WHERE device_id = :device_id");
    $stmt->bindParam(":device_id", $device_id);
    $stmt->execute();
    $dateTime_column = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($dateTime_column as $row) {
        // Date DB
        $timeString = $row['date_time'];
        $hoursMinutes = strtotime($timeString);
        // Date JS
        $clickDate = strtotime($date);
        $nextDay = strtotime($date . "+ 1 day");

        if( $hoursMinutes >= $clickDate && $hoursMinutes < $nextDay ) {
            // Set Time to date DB
            $setTime = date("H:i:a", $hoursMinutes);
            // Get value
            $resultValue = $row['value'];
            $resultArray[] = array($setTime, $resultValue);
        }
    }  
        echo json_encode($resultArray);
        exit;
}
?>
