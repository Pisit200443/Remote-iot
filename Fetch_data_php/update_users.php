<?php
require_once '../server.php';

if (isset($_POST['edit_user'])) {
    $FirstName = $_POST['firstname'];
    $LastName = $_POST['lastname'];
    $Password = $_POST['password'];
    $PhoneNumber = $_POST['phoneNumber'];
    $user_id = $_POST['user_id'];

    $passwordHash = password_hash($Password, PASSWORD_DEFAULT);

    $updateUser = $conn->prepare("UPDATE user SET firstname = :firstname, lastname = :lastname, password = :password, 
                                phone_number = :phoneNumber, user_id = :user_id WHERE user_id = :user_id");
    $updateUser->bindParam(":firstname", $FirstName);
    $updateUser->bindParam(":lastname", $LastName);
    $updateUser->bindParam(":password", $passwordHash);
    $updateUser->bindParam(":phoneNumber", $PhoneNumber);
    $updateUser->bindParam(':user_id', $user_id);
    $updateUser->execute();
    exit();

    header("Location: ../Admin/users_manage.php");
} else {
    header("Location: ../Admin/users_manage.php");
}
?>
