<?php
require_once '../server.php';

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']); 
    
    try {
        
        $conn->beginTransaction();

        $stmt = $conn->prepare("DELETE FROM user WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
      
        $conn->commit();

        header("Location: ../Admin/users_manage.php?success=Deleted successfully!");
    } catch (PDOException $e) {
        $conn->rollback(); 
        header("Location: ../Admin/users_manage.php?error=Error deleting user. " . $e->getMessage());
    }
} else {
    header("Location: ../Admin/users_manage.php?error=User ID not specified!");
}
?>
