<?php
    session_start();
    require_once '../../config/server.php';

    if (isset($_SESSION['user_id'])) {
        $countUser = $conn->prepare("SELECT status FROM user WHERE user_id = :user_id");
        $countUser->bindParam(':user_id', $_SESSION['user_id']);
        $countUser->execute();
        $resultStatus = $countUser->fetch(PDO::FETCH_ASSOC);

        if ($resultStatus['status'] === 'admin') {
            $statusAdmin = $resultStatus['status'];

        } else {
            header('location: ../views/login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Please log in!';
        header('location: ../views/login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #4c7ba5;
        }
        .container-fluid {
            display: flex;
            flex-direction: column;
        }
        .head {
            margin-top:30px ;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .head h1 {
            color:white;
            margin-left:115px ;
        }
        .row{
            display: flex;
            width: 100%;
            height: auto;
            justify-content: center;
        }
        .box-1 {
            margin-top:10px ;
            width: 30%;
            height: auto;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .box-2 {
            width: 50%;
            height: auto;
            margin-top:26px ;
        }
        .displayCard {
            width: 350px;
            height: 150px;
            background: white;
            border-left: 60px solid #007bff;
            border-radius: 10px 10px 10px 10px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
        }
        .text p {
            color: blue;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 9px;
        }
        .icon {
          font-size: 50px;
        }
        .enhanced-table {
          border-radius: 15px;
          overflow: hidden;  
          background-color: white;
          border-collapse: collapse;
          width: 100%;
          box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }
        /* Removing table borders */
        .enhanced-table th, .enhanced-table td {
          border: none !important;
        }
        .enhanced-table tbody tr {
          border-bottom: none !important;
        }
        .enhanced-table th, .enhanced-table td {
          padding: 12px 15px;
        }
        .enhanced-table tbody tr {
          border-bottom: 1px solid #e0e0e0;
        }
        .enhanced-table tbody tr:last-of-type {
          border-bottom: 0;
        }
        .enhanced-table tbody tr:hover {
          background-color: #f5f5f5;
        }
        .enhanced-table th {
          background-color: #007bff;
          color: white;
          text-transform: uppercase;
          font-size: 14px;
          text-align:center;

        }
        .enhanced-table td {
          font-size: 14px;
          color: #333;
          text-align: center
        }
        tbody, td, tfoot, th, thead, tr {
            border-color: inherit;
            border-width: 0;
        }
    </style>
</head>
<body>
<?php
    include 'navbar_admin.php';
    // Count users
    $countUser = $conn->prepare("SELECT COUNT(user_id) as total_user FROM user WHERE status = 'user'");
    $countUser->execute();
    $totalUser = $countUser->fetch(PDO::FETCH_ASSOC);

    // Count devices all
    $countDevices = $conn->prepare("SELECT COUNT(device_id) as total_device FROM device");
    $countDevices->execute();
    $totalDevices = $countDevices->fetch(PDO::FETCH_ASSOC);
    
    // Get date data to schedule table
    $getDateAction = $conn->prepare("SELECT * FROM schedule JOIN device ON schedule.device_id = device.device_id 
                      WHERE status = '1' ORDER BY date_time ASC LIMIT 20");
    $getDateAction->execute();
    $resultDate = $getDateAction->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="head">
    <h1>Dashboard</h1>
</div>
<div class="row">
    <div class="box-1">
        <div class="displayCard">
            <div class="text">
                <p>TOTAL USERS</p>
                <h2><?= $totalUser['total_user'] ?></h2>
            </div>
            <div class="icon"><i class="bi bi-people-fill"></i></div>
        </div>
        <div class="displayCard">
            <div class="text">
                <p>TOTAL DEVICES</p>
                <h2><?= $totalDevices['total_device'] ?></h2>
            </div>
            <div class="icon"><i class="bi bi-phone-fill"></i></div>
        </div>
    </div>
    <div class="box-2">
        <table class="table table-bordered table-striped enhanced-table">
            <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>Button</th>
                    <th>Device Name</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (isset($resultDate)) { 
                    foreach ($resultDate as $date) { 
                ?>
                        <tr data-device-id="<?= $date['device_id'] ?>">
                            <td> <?= $date['date_time'] ?></td>
                            <td> <?= $date['value'] ?></td>
                            <td> <?= $date['device_name'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>  
            </tbody>
        </table>
    </div>   
</div>
</body>
</html>