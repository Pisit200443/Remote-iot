<?php 
session_start();
require_once '../../config/server.php';

if (isset($_POST['create_user'])) {
    $FirstName = $_POST['firstname'];
    $LastName = $_POST['lastname'];
    $UserName = $_POST['username'];
    $Password = $_POST['password'];
    $PhoneNumber = $_POST['phoneNumber'];

        try {
            $checkUserName = $conn->prepare("SELECT username FROM user WHERE username = :username");
            $checkUserName->bindParam(":username", $UserName);
            $checkUserName->execute();

            if ($checkUserName->rowCount() > 0) {
                $_SESSION['warning'] = "This Username already exists in the system.";
                header("location: ../../views/admin/user_management.php");
                exit();
            } else {
                $passwordHash = password_hash($Password, PASSWORD_DEFAULT);
                $status = 'user';
                $stmt = $conn->prepare("INSERT INTO user (firstname, lastname, username, password, phone_number, status) 
                                        VALUES(:firstname, :lastname, :username, :password, :phoneNumber, :status)");
                $stmt->bindParam(":firstname", $FirstName);
                $stmt->bindParam(":lastname", $LastName);
                $stmt->bindParam(":username", $UserName);
                $stmt->bindParam(":password", $passwordHash);
                $stmt->bindParam(":phoneNumber", $PhoneNumber);
                $stmt->bindParam(":status", $status);
                $stmt->execute();
                $_SESSION['success'] = "You have successfully applied for membership!";
                header("location: ../../views/admin/user_management.php");
                exit();
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
?>
