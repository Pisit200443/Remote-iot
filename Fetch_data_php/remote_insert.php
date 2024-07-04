<?php

session_start();
require_once('../server.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $content = trim(file_get_contents("php://input"));
    $data = json_decode($content, true);

    $device_id = $data['device_id'] ?? '';
    $value = $data['value'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM real_time WHERE device_id = :device_id");
    $stmt->bindParam(":device_id", $device_id);
    $stmt->execute();
    $value_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($value_row) {
        if ($value_row['value']) {
            $stmt = $conn->prepare("UPDATE real_time SET value = :value, create_at = NOW(), status = '1' WHERE device_id = :device_id");
            $stmt->bindParam(":value", $value);
            $stmt->bindParam(":device_id", $device_id);
            $stmt->execute();
            echo json_encode(["status" => "success", "message" => "Data updated successfully"]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "No changes detected."]);
            exit;
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO real_time (device_id, value, status) VALUES (:device_id, :value, '1')");
        $stmt->bindParam(":device_id", $device_id);
        $stmt->bindParam(":value", $value);
        $stmt->execute();
        echo json_encode(["status" => "success", "message" => "Data inserted successfully"]);
        exit;
    }
}
?>
