<?php

session_start();
require_once 'server.php';

if (isset($_POST['register'])) {
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($c_password)) {
        $_SESSION['error'] = 'Please fill in all fields.';
        header("location: register.php");
        exit(); 
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format';
        header("location: register.php");
        exit();
    } elseif (strlen($password) > 20 || strlen($password) < 5) {
        $_SESSION['error'] = 'Password must be between 5 and 20 characters long.';
        header("location: register.php");
        exit();
    } elseif ($password != $c_password) {
        $_SESSION['error'] = "Passwords don't match";
        header("location: register.php");
        exit();
    }

    try {
        $check_email = $conn->prepare("SELECT email FROM user WHERE email = :email");
        $check_email->bindParam(":email", $email);
        $check_email->execute();

        if ($check_email->rowCount() > 0) {
            $_SESSION['warning'] = "This email already exists in the system.";
            header("location: register.php");
            exit();
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password) 
                                VALUES (:firstName, :lastName, :email, :password)");
        $stmt->bindParam(":firstName", $firstname);
        $stmt->bindParam(":lastName", $lastname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $passwordHash);
        $stmt->execute();

        $_SESSION['success'] = "You have successfully applied for membership!";
        header("location: login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Something went wrong! Please check.";
        header("location: register.php");
        exit();
    }
}

?>
