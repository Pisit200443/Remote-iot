<?php 
    session_start();
    session_destroy();
    unset($_SESSION['user_login']);
    header('location: ../views/login.php');
?>