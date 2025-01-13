<?php
session_start();
require_once '../../config/server.php';

if (isset($_SESSION['user_id'])) {
    $checkStatus = $conn->prepare("SELECT status FROM user WHERE user_id = :user_id");
    $checkStatus->bindParam(':user_id', $_SESSION['user_id']);
    $checkStatus->execute();
    $resultStatus = $checkStatus->fetch(PDO::FETCH_ASSOC);

    if ($resultStatus['status'] !== 'admin') {
        header('location: ../views/login.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Please log in!';
    header('location: ../views/login.php');
    exit();
}

if (isset($_GET['firstname'])) {
    $firstname = $_GET['firstname'];

    $getUsers = $conn->prepare("SELECT user_id, firstname, lastname, status FROM user WHERE firstname LIKE :firstname AND status = 'user'");
    $getUsers->execute(array(':firstname' => '%' . $firstname . '%'));
    $users = $getUsers->fetchAll(PDO::FETCH_ASSOC);
} else {
    // หากไม่ได้รับข้อมูลการค้นหา ให้ดึงข้อมูลทั้งหมด
    $getUsers = $conn->prepare("SELECT user_id, firstname, lastname, status FROM user WHERE status = 'user'");
    $getUsers->execute();
    $users = $getUsers->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Management</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #4c7ba5;
        }
        .head {
          width: 100%;
          height: auto;
          margin-top:30px;
          display: flex;
          justify-content: space-between;
          align-items: center;
          color:white;
        }
        .head h1{
          margin-left:115px ;
        }
        .btn {
          width: 124px;
          height: 40px;
          margin-right: 15px;
          color: #001ebb;
          border-radius: 8px;
          font-size:16px;
          border:none;
        }
        .card-container {
          display: flex;
          flex-wrap: wrap;
          margin-top: 20px;
          padding-left:20px ;
          color: white;
        }
        .card {
          width: 200px;
          height: 200px;
          background-color: #2f323d;
          border-radius: 10px;
          margin: 20px;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
        }
        .card-content {
          margin-top:10px ;
          text-align: center;
          width: 146px;
          height: auto;
        }
        .card-icon{
          width: 100%;
          height: auto;
          text-align:center;
        }
        .card-icon i{
          font-size:50px;
          margin-buttom:10px ;
          color: #1962ad;
        }
        .card-content h3 {
          margin: 0;
        }
        .card-content p{
          overflow: hidden;
          text-overflow: ellipsis; 
          white-space: nowrap; 
        }
        .search-container input {
          padding: 5px;
          border: 1px solid #ced4da;
          border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include 'navbar_admin.php'; ?>

<div class="container">
  <div class="head">
    <h1>Devices Management</h1>
    <!-- display search -->
    <!-- <div class="search-container">
      <form action="devices_manage.php" method="GET">
        <input type="text" name="firstname">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
      </form>
    </div> -->
  </div>
  
  <!-- display card user -->
  <div class="card-container">
    <?php foreach ($users as $user): ?>
        <div class="card">
            <div class="card-icon">
            <a href="device_remote.php?user_id=<?php echo $user['user_id']; ?>">
                <i class="bi bi-person-circle"></i>
            </a>
            </div>
            <div class="card-content">
                <p><?php echo $user['firstname']. ' '.$user['lastname'] ; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
  </div>
</div>

</body>
</html>
