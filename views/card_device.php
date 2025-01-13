<?php
    session_start();
    require_once '../config/server.php';

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = 'Please log in!';
        header('location: login.php');
        exit();
    }

    $check_data = $conn->prepare("SELECT device_id, device_name, location, description FROM device WHERE user_id = :user_id");
    $check_data->bindParam(":user_id", $_SESSION['user_id']);
    $check_data->execute();
    $devices = $check_data->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-GLhlTQ8iKlZP+Vd+RXPn..."></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #4c7ba5;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .card-container {
            display: flex;
            border-radius: 20px; 
        }
        .card-image {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 140px;
            height: 150px;
            border-radius: 7px;
        }
        a {
            display:flex;
            justify-content: center;
        }
        .container {
            text-align: center;
            color: white;
            padding: 10px 10px;
        }
        .card{
            padding: 20px;
            background-color: #2f323d;
            width: 260px;
            height: 280px;
            margin: 35px 20px;
        }
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
        .card-content{
            margin-top: 10px;
            color: white;
        }
        .card-content p{
            font-size:20px;
            overflow: hidden;
            text-overflow:ellipsis;
            white-space: nowrap;
        }
        .button-remote{
            background-color: #007fff;
            color: #fff;
            border: none;
            border-radius: 6px;
            width: 300px;
            height: 280px;
            margin: 20px;
        }
        .button-remote:hover{
            background-color: #218838;
        }
        .button-remote i{
            font-size:56px;
        }
        button {
            background-color: #007fff;
            color: #fff;
            border: none;
            border-radius: 6px;
            width: 105px;
            height: 45px;
            margin: 20px 20px 20px 10px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<?php
    include 'navbar_user.php';

    $check_data = $conn->prepare("SELECT device_id, device_name, location FROM device WHERE user_id = :user_id");
    $check_data->bindParam(":user_id", $_SESSION['user_id']);
    $check_data->execute();
    $devices = $check_data->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="card-container">
    <?php foreach ($devices as $device): ?>
         <div class="card">
            <a href="remote_control.php?device_id=<?php echo $device['device_id']; ?>">
                <img src="../images/remote-control.png" class="card-image">
            </a>
            <div class="card-content">
                <p>Device: <?php echo $device['device_name']; ?></p>
                <p>Location: <?php echo $device['location']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>