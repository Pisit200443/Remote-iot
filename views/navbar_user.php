<?php 
    require_once '../config/server.php';

      if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = 'Please log in!';
        header('location: login.php');
        exit();
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
      @import url('https://fonts.googleapis.com/css2?family=Anton&family=Kanit:wght@300&family=Overpass&display=swap');
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
        /* position: fixed; */
        top: 0;
        width: 100%;
        height: 80px;
        left: 0;
        background-color: var(--white-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 0px 11px 30px;
        margin: auto;
        z-index: 1000;
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
          margin-left: 60px;
          padding-top: 9px;
          font-family: 'Anton', sans-serif;
        }
        .textuser{
          margin: 9px 15px 9px 9px;
          color: #4070F4;
          font-size: 22px;
          font-weight: bolder;
          font-family: 'Roboto', sans-serif;
        }
        .navbar_content{
          padding-left:15px ;
        }
        .userbutton{
          display:flex;
        }
        .buttonout{
          /* padding-left:25px ; */
          width: 40px;
          height: 40px;
        }
        .buttonout i{
          font-size:30px;
          color: red;
          margin-left:auto ;
        }
        .btnout{
          width: auto;
          border:none;
          background: none;
          margin: 0;
        }
    </style>

  </head>
  <body> 
   
    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <div class="boximg">
            <img class="imglogo"src="../images/logo3.png" alt="">
            </div>
            <h3 class="textlogo"> Smart Remote </h3>
        </div>

        <div class="userbutton">
          <div class="navbar_content">
            <?php 
              $user_id = $_SESSION['user_id'];
              $stmt = $conn->query("SELECT * FROM user WHERE user_id = $user_id");
              $stmt->execute();
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
              <p class="textuser"> <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></p>
          </div>
          <div class="buttonout">
            <button class="btnout" type="button" onclick="logOutAlert(<?php echo $user_id; ?>)"><i class="b2 bi bi-door-closed-fill"></i></button>
          </div>     
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
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../controllers/logout.php?user_id=' + user_id;
                }
            });
        }
    </script>
  </body>
</html>