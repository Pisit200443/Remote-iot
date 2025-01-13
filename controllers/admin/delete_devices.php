<?php
require_once '../../config/server.php';

if (isset($_GET['device_id'])) {
    $device_id = intval($_GET['device_id']); 
    $user_id = $_GET['user_id']; 
    try {
        
        $conn->beginTransaction();

        $stmt = $conn->prepare("DELETE FROM device WHERE device_id = :device_id");
        $stmt->bindParam(':device_id', $device_id);
        $stmt->execute();
      
        $conn->commit();

        header("Location: ../../views/admin/device_remote.php?user_id={$user_id}");
    } catch (PDOException $e) {
        $conn->rollback(); 
        header("Location: ../../views/admin/device_remote.php?error=Error deleting user. " . $e->getMessage());
    }
} else {
    header("Location: ../../views/admin/device_remote.php?error=User ID not specified!");
}
?>
