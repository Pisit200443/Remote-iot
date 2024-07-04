<?php 
session_start();
require_once '../server.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $checkData = $conn->prepare("SELECT * FROM user WHERE username = :username");
        $checkData->bindParam(":username", $username);
        $checkData->execute();
        $Result = $checkData->fetch(PDO::FETCH_ASSOC);

        if ($username == $Result['username']) {
            if (password_verify($password, $Result['password'])) {
                $_SESSION['user_id'] = $Result['user_id'];
                
                if ($Result['status'] == 'admin') {
                    header("location: ../Admin/dashboard.php");
                    exit();
                } else if ($Result['status'] == 'user') {
                    header("location: ../card_device.php?user_id={$_SESSION['user_id']}");
                    exit();
                }
    
            } else {
                $_SESSION['error'] = 'Username or password is incorrect.';
                header("location: login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = 'This username was not found in the system.';
            header("location: login.php");
            exit();
        }

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}
?>
