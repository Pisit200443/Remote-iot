<?php 
session_start();
require_once '../server.php';

if (isset($_POST['add_device'])) {
    $DeviceName = $_POST['device_name'];
    $Location = $_POST['location'];
    $Description = $_POST['description'];
    $user_id = $_POST['user_id'];

        try {
            $stmt = $conn->prepare("INSERT INTO device (device_name, location, description, user_id) 
                                    VALUES(:Device_name, :Location, :Description, :user_id)");
            $stmt->bindParam(":Device_name", $DeviceName);
            $stmt->bindParam(":Location", $Location);
            $stmt->bindParam(":Description", $Description);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            $_SESSION['success'] = "You have successfully applied for membership!";
            header("location: ../Admin/device_remote.php?user_id={$user_id}");

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
?>
