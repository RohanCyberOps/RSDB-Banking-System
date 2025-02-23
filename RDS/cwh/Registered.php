<?php
session_start();

// Check if the user is logged in after registration
if (!isset($_SESSION['user_name'])) {
    header("Location: RDS/php-login-form/login-action.php"); // Redirect to login if session is not set
    exit();
}

$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RSD Bank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Gabriela&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
        #header {
            height: 100vh;
            background-image: url(../resources/images/background.png);
            background-position: center;
            background-size: cover;
        }
        .container {
            margin-right: 100px;
            margin-left: 100px;
        }
        .logoParent {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 200px;
        }
        .titlesss {
            margin-bottom: -5px;
            margin-left: 20px;
            font-family: 'Gabriela', serif;
            font-size: 27px;
        }
        .header-text {
            max-width: 350px;
            margin-top: 140px;
        }
        .header-text h1 {
            font-size: 34px;
        }
        .square {
            height: 12px;
            width: 12px;
            display: inline-block;
            background: #f67c92;
            margin: 15px 0;
        }
        .button {
            padding: 18px 40px;
            background: transparent;
            outline: none;
            border: 2px solid #f67c92;
            font-weight: bold;
            cursor: pointer;
        }
        p {
            font-size: 15px;
            line-height: 18px;
            color: #777;
        }
    </style>
</head>
<body>
<section id="header">
    <div class="container">
        <div class="logoParent">
            <div><img src="../resources/images/icon2.png" class="logo"></div>
            <div class="titlesss">RSD Bank</div>
        </div>
        <div class="header-text">
            <h1>Welcome to RSD Bank, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <span class="square"></span>
            <p>Your account has been successfully created. Start managing your finances with our secure and reliable banking services.</p>
            <a href="dashboard.php"><button class="button">Go to Dashboard</button></a>
            <a href="../view/logout.php"><button class="button">Logout</button></a>
        </div>
    </div>
</section>
</body>
</html>
