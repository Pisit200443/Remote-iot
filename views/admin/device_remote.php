<?php
    session_start();
    require_once '../../config/server.php';

    if (isset($_SESSION['user_id'])) {
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];

            $check_data = $conn->prepare("SELECT * FROM device WHERE user_id = :user_id");
            $check_data->bindParam(":user_id", $user_id);
            $check_data->execute();
            $devices = $check_data->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Device</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-GLhlTQ8iKlZP+Vd+RXPn..."></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body{
            font-family: 'Roboto', sans-serif;
            background-color: #4c7ba5;
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
        .card {
            padding: 10px;
            background-color: #2f323d;
            width: 260px;
            height: 230px;
            margin: 20px;
        }
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
        .btn-card{
            text-align:end;
            margin: 0px 5px;
            display: flex;
            justify-content: flex-end;
        }
        .card img {
            margin-top:5px ;
            width: 120px;
            height: 120px;
        }
        .card-content {
            margin-top: 10px;
            color: white;
            overflow: hidden;
            text-overflow: ellipsis; 
            white-space: nowrap;
        }
        .card-content p {
            font-size:20px;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
        }

        .head {
            margin-top:30px ;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom:15px ;
        }
        .head h1 {
            color:white;
            margin-left:115px ;
            font-size: 32px;
            font-weight: bold;
        }
        .btn-edit {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background:green;
            border:none;
            color:white;
            margin-right: 8px; 
        }
        .btn-del {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border:none;
            background:red;
            color:white;
        }
        .btn-create{
            margin-right:115px ;
        }
    </style>
</head>
<body>
<?php include 'navbar_admin.php'; ?>
<div class="head">
    <h1>All devices</h1>
    <button class="btn btn-primary btn-create" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-plus-lg"></i> Create Device</button>
</div>
<div class="card-container">
    <?php if(isset($devices)): ?>
        <?php foreach ($devices as $device): ?>
        <?php 
            $user_id = $_GET['user_id'];
            $device_id = $device['device_id'];
            $deviceName = $device['device_name'];
            $deviceLocation = $device['location'];
            $deviceDescrip = $device['description'];
        ?> 
            <div class="card">
                <div class="btn-card mb-2">
                    <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal"onclick="updateDevice('<?php echo $device['device_id']; ?>')"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn-del" onclick="confirmDelete('<?php echo $device['device_id']; ?>')"><i class="bi bi-trash3"></i></button>
                </div>
                <a href="../remote_control.php?device_id=<?php echo $device['device_id']; ?>">
                    <img src="../../images/remote-control.png" class="card-image">
                </a>
                <div class="card-content">
                    <p id="deviceName<?php echo $device_id; ?>"><?php echo $device['device_name']; ?></p>
                    <p id="location<?php echo $device_id; ?>" style="display: none;"><?php echo $device['location']; ?></p>
                    <p id="description<?php echo $device_id; ?>" style="display: none;"><?php echo $device['description']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Modal add remote -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../controllers/admin/add_devices.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="deviceName" class="form-label">Device Name</label>
                        <input type="text" class="form-control" name="device_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
                    <div class="modal-footer">
                        <button type="submit" name="add_device" class="btn btn-primary">Add Card</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit remote -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Device</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../../controllers/admin/update_devices.php" method="post">
            <div class="mb-3">
                <label for="deviceName" class="form-label">Device Name</label>
                <input type="text" class="form-control" id="displayDeviceName" value="" disabled>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="displayLocation" name="location" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="displayDescription" name="description" rows="3"></textarea>
            </div>
            <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
            <input type="hidden" id="deviceId" name="device_id">
            <button type="submit" name="edit_device" class="btn btn-primary">Done</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // sweet alert
    function confirmDelete(device_id) {
        console.log();
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to delete this device?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../../controllers/admin/delete_devices.php?device_id=' + device_id + '&user_id=<?php echo $user_id; ?>';
            }
        });
    }

    // update device
    function updateDevice (device_id) {
        let deviceName = document.getElementById('deviceName' + device_id).innerText;
        let deviceLocation = document.getElementById('location' + device_id).innerText; 
        let deviceDescription = document.getElementById('description' + device_id).innerText; 

        document.getElementById('displayDeviceName').value = deviceName;
        document.getElementById('displayLocation').value = deviceLocation; 
        document.getElementById('displayDescription').value = deviceDescription;
        document.getElementById('deviceId').value = device_id;
    }
</script>
</body>
</html>