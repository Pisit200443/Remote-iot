<?php 
    session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logination</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #4c7ba5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #2f323d;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            border-radius: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            color: #e4dddd;
        }

        input {
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        button {
            background-color: #1962ad;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        /* Add some responsive design for better user experience on smaller screens */
        @media only screen and (max-width: 600px) {
            .container {
                width: 80%;
            }
        }
        .action-link {
            color: #0066cc;
            font-weight: 500;
            transition: color 0.3s ease-in-out;
            text-decoration: none; 
        }

        .alert {
            text-align:center;
            font-size: 25px;
            color: white;
        }

        .image {
            display: flex;
            justify-content: center;
        }

        .image-logo {
            width: 30%;
            height: 45%;
            display: flex;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="image">
            <img class="image-logo"src="../image/logo4.png" alt="">
        </div>
        <div style ="text-align:center;">
            <h1><label for="Login">Login</label></h1>
        </div>
        
        <form action="../controllers/login.php" method="post">

            <?php if (isset($_SESSION ['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION ['error'];
                        unset($_SESSION ['error']);
                    ?>
                </div>
            <?php } ?>

            <?php if (isset($_SESSION ['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION ['success'];
                        unset($_SESSION ['success']);
                    ?>
                </div>
            <?php } ?>

            <?php if (isset($_SESSION ['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php 
                        echo $_SESSION ['warning'];
                        unset($_SESSION ['warning']);
                    ?>
                </div>
            <?php } ?>

            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
 
</body>
</html>
