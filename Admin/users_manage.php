<?php
  session_start();
  require_once '../server.php';

  if (isset($_SESSION['user_id'])) {
      $checkStatus = $conn->prepare("SELECT status FROM user WHERE user_id = :user_id");
      $checkStatus->bindParam(':user_id', $_SESSION['user_id']);
      $checkStatus->execute();
      $resultStatus = $checkStatus->fetch(PDO::FETCH_ASSOC);

      if ($resultStatus['status'] !== 'admin') {
        header('location: ../Login/login.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Please log in!';
    header('location: ../Login/login.php');
    exit();
}

if (isset($_GET['firstname'])) {
  $firstname = $_GET['firstname'];

  $getUsers = $conn->prepare("SELECT user_id, firstname, lastname, status FROM user WHERE firstname LIKE :firstname AND status = 'user'");
  $getUsers->execute(array(':firstname' => '%' . $firstname . '%'));
  $users = $getUsers->fetchAll(PDO::FETCH_ASSOC);
} else {
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
    <title>Users Manage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
          font-family: 'Roboto', sans-serif;
          background-color: #4c7ba5;
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
        tbody, td, tfoot, th, thead, tr{
          border-style:none;
        }
        .icon-td {
          display:flex;
          justify-content: center;
          align-items: center;
        }
        .green{
          width: 40px;
          height: 40px;
          border-radius: 8px;
          font-size:16px;
          background:green;
          border:none;
          color:white;
          margin-right: 8px;
        }
        .red{
          width: 40px;
          height: 40px;
          border-radius: 8px;
          font-size:16px;
          border:none;
          background:red;
          color:white;
        }
        .head{
          margin-top:30px ;
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom:15px ;
        }
        .head h1{
          color:white;
          font-size: 32px;
          font-weight: bold;
        }
        .search-container input {
          padding: 5px;
          border: 1px solid #ced4da;
          border-radius: 5px;
        }
    </style>
</head>
<body>
<?php 
    include 'navbar_admin.php'; 

    $status = 'user';
    $checkUser = $conn->prepare("SELECT * FROM user WHERE status = :status");
    $checkUser->bindParam(':status', $status);
    $checkUser->execute();
    $resultUsers = $checkUser->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
  <div class="head">
    <h1>User Managed</h1>
    <!-- display search -->
    <!-- <div class="search-container">
      <form action="users_manage.php" method="GET">
        <input type="text" name="firstname">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
      </form>
    </div> -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-person-plus-fill"></i>  Create User</button>
  </div>
    <center>
    <table class="table table-bordered table-striped enhanced-table" id="matchedDevicesTable" style="width: 1100px;">
        <thead class="thead-dark">
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Username</th>
                <th>Tel.</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <center>
            <?php
            if (isset($resultUsers)) {
                foreach ($resultUsers as $user) {
                  $userID = $user['user_id'];
                  $firstName = $user['firstname'];
                  $lastName = $user['lastname'];
                  $userName = $user['username'];
                  $phoneNumber = $user['phone_number'];
                  $create_at = $user['create_at'];
            ?>
              <tr data-user-id="<?= $userID;?>">
                <td id="firstName_id<?= $userID; ?>"><?= $firstName ?></td>
                <td id="lastName_id<?= $userID; ?>"><?= $lastName ?></td>
                <td id="UserName_id<?= $userID; ?>"><?= $userName ?></td>
                <td id="Phone_id<?= $userID; ?>"><?= $phoneNumber ?></td>
                <td id="create_id<?= $userID; ?>"><?= $create_at ?></td>  
                <td class="icon-td">
                  <button class="green" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="setUserData(<?= $userID ?>)">
                    <i class="bi bi-pencil-square"></i>                               
                  </button>
                  <button class="red"onclick="confirmDelete(<?= $userID ?>)"><i class="bi bi-trash3-fill"></i></button>
                </td>
              </tr>
            <?php
                }
            }
            ?>
            </center>
        </tbody>
    </table>
    </center>

    <!-- Modal create user-->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Create user</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../Fetch_data_php/add_users.php" method="post">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Firstname</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Lastname</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="create_user">Create</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>

    <!-- Modal edit user-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="../Fetch_data_php/update_users.php?user_id=<?=  $userID ?>" method="post">
                  <div class="mb-3">
                  <input type="hidden" id="User_id" name="user_id">
                      <label for="firstname" class="form-label">Firstname</label>
                      <input type="text" class="form-control" id="displayFirstName" name="firstname" required>
                  </div>
                  <div class="mb-3">
                      <label for="lastname" class="form-label">Lastname</label>
                      <input type="text" class="form-control" id="displayLastName" name="lastname" required>
                  </div>
                  <div class="mb-3">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" class="form-control" id="displayUserName" value="" disabled>
                  </div>
                  <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" name="password" required>
                  </div>
                  <div class="mb-3">
                      <label for="phoneNumber" class="form-label">Phone Number</label>
                      <input type="tel" class="form-control" id="displayPhoneNumber" name="phoneNumber">
                  </div>
                  <input type="hidden" id="userId" name="user_id">
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" name="edit_user">Save</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div> 
              </from>
          </div>
        </div>
      </div>
    </div>

</div>

<script>
      // Set format phone number
      document.getElementById('phoneNumber').addEventListener('input', function (e) {
      let phoneNumber = e.target.value.replace(/\D/g, '').substring(0, 10); // เอาเฉพาะตัวเลขและจำกัดจำนวนได้แค่ 10 ตัว
      let formattedPhoneNumber = phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3'); // กำหนดรูปแบบของเบอร์โทรศัพท์เป็น 000-000-0000
      e.target.value = formattedPhoneNumber; // กำหนดค่าให้กับ input element
    });

    // Sweet alert
    function confirmDelete(user_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to delete this match?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../Fetch_data_php/delete_users.php?user_id=' + user_id;
            }
        });
    }

    // Display show model edit
    function setUserData(user_id) {
      let getFirstName = document.getElementById('firstName_id' + user_id).innerText;
      let getLastName = document.getElementById('lastName_id' + user_id).innerText;
      let getUserName = document.getElementById('UserName_id' + user_id).innerText;
      let getPhone = document.getElementById('Phone_id' + user_id).innerText;
      
      document.getElementById('userId').value = user_id;
      document.getElementById('displayFirstName').value = getFirstName;
      document.getElementById('displayLastName').value = getLastName;
      document.getElementById('displayUserName').value = getUserName;
      document.getElementById('displayPhoneNumber').value = getPhone;
    }
</script>
</body>
</html>