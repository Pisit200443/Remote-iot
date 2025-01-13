<?php
require_once '../../config/server.php';

if (isset($_POST['edit_device'])) {
    $DeviceName = $_POST['device_name'];
    $Location = $_POST['location'];
    $Description = $_POST['description'];
    $user_id = $_POST['user_id'];
    $device_id = $_POST['device_id'];

    $updateDevice = $conn->prepare("UPDATE device SET device_name = :device_name, location = :location, description = :description, user_id = :user_id WHERE device_id = :device_id");
    $updateDevice->bindParam(":device_name", $DeviceName);
    $updateDevice->bindParam(":location", $Location);
    $updateDevice->bindParam(":description", $Description);
    $updateDevice->bindParam(':user_id', $user_id);
    $updateDevice->bindParam(':device_id', $device_id);
    $updateDevice->execute();

    header("Location: ../../views/admin/device_remote.php?user_id={$user_id}");
} else {
    header("Location: ../views/admin/device_remote.php?user_id={$user_id}");
}
?>
