<?php 
    if (!isset($_SESSION)) { 
        session_start();
        require_once '../server.php';

    if (isset($_SESSION['user_id'])) {
        $checkStatus = $conn->prepare("SELECT status FROM user WHERE user_id = :user_id");
        $checkStatus->bindParam(':user_id', $_SESSION['user_id']);
        $checkStatus->execute();
        $resultStatus = $checkStatus->fetch(PDO::FETCH_ASSOC);

        if ($resultStatus['status'] === 'admin') {
            $statusAdmin = $resultStatus['status'];
        } else {
            header('location: ../Login/login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Please log in!';
        header('location: ../Login/login.php');
        exit();
    }
  }
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Navbar</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Kanit:wght@300&family=Overpass&display=swap');
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
        }
        :root {
        --white-color: #fff;
        --blue-color: #4070f4;
        --grey-color: #707070;
        --grey-color-light: #aaa;
        }
       
        body.dark {
        --white-color: #333;
        --blue-color: #fff;
        --grey-color: #f2f2f2;
        --grey-color-light: #aaa;
        }

        .navbar {
            top: 0;
            width: 100%;
            height: 80px;
            left: 0;
            background-color: var(--white-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 30px;
            margin: auto;
            z-index: 1000;
            box-shadow: 0px -40px 120px black;
        }

        .logo_item {
            display: flex;
            align-items: center;
            column-gap: 10px;
            font-size: 22px;
            font-weight: 500;
            color: var(--blue-color);
        }
        
        .navbar img {
            margin-bottom: 15px;
        }

        .navbar_content i {
            cursor: pointer;
            font-size: 20px;
            color: var(--grey-color);
        }

        .textuser {
            font-size: 19px;
        }

        .boximg{
            width:223px;
            height: 55px;

        }

        .imglogo{
            width: 100%;
            height: 100%;
            object-fit:fill;
          
        }

        .textlogo{
            margin-left: 5px;
            padding-top: 9px;
            font-family: 'Anton', sans-serif;
        }

        .textuser{
            margin:9px ;
            color:#4070F4;
            font-size:20px;
            font-family: 'Overpass', sans-serif;
        }

        .userbutton {
            display:flex;
        }

        .nav-menu{
            display: flex;
            justify-content: center;
            width: auto;
            height: auto;
            
        }
        .text-menu a{
            margin-right:30px;
            text-decoration: none;
            font-size:22px;
            font-family: 'Bebas Neue', sans-serif;
            color:rgb(43, 0, 255);
            padding: 3px 4px;
        }
        .text-menu a:hover {
            font-size:24px;
            color:grey;
        }
        .navbar-content{
            display:flex;
            align-items: center;
        }
        .b1{
            font-size:33px;
            color:rgb(23 117 200);
            margin-right:10px;
        }
        .b2{
            font-size:33px;
            color:#e21a1a;
        }
        .button{
            border:none;
            background:none ;
        }
    </style>

</head>
<body> 
    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <div class="boximg" href="admin_page.php">
                <img class="imglogo"src="../image/logo3.png" alt="">
            </div>
        </div>
        <div class="nav-menu">
            <div class="text-menu"><a  href="dashboard.php">DashBoard</a></div>
            <div class="text-menu"><a  href="users_manage.php">User Manage</a></div>
            <div class="text-menu"><a  href="devices_manage.php">Device Manage</a></div>
        </div>
        <div class="userbutton">
            <div class="navbar-content">
                <?php 
                    $user_id = $_SESSION['user_id'];
                    $stmt = $conn->query("SELECT * FROM user WHERE user_id = $user_id");
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <a href="#"><i class="b1 bi bi-person-circle"></i></a>
                
            </div>
            <button class="button" type="button" onclick="logOutAlert(<?php echo $user_id; ?>)"><i class="b2 bi bi-door-closed-fill"></i></button>
        </div>  
    </nav>

    <script>
        function logOutAlert(user_id) {
            Swal.fire({
                title: 'Are you sure logout?',
                text: "Are you sure you want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../Login/logout.php?user_id=' + user_id;
                }
            });
        }
    </script>
</body>
</html>