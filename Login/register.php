<?php 
    session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/3f4bc942b9.js" crossorigin="anonymous"></script>
    <style>
        body {
        font-family: 'Roboto', sans-serif;
        background-color: #515860;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        }

        .container {
            background-color: #2f323d;
            padding: 45px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            border-radius: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
            background-color: #007fff;
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

    </style>
</head>
<body>
    <div class="container">
        <div style ="text-align:center;">
            <h1><label for="Register">Register</label></h1>
        </div>
        <form action="register_db.php" method="post">
            
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

            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="email">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Confirm Password:</label>
            <input type="password" id="password" name="c_password" required>

            <button type="submit" name="register">Register</button>
        </form>
            <p><a href="login.php" class="action-link">Back</a></p>
    </div>
</body>
</html>
