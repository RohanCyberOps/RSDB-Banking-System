<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: SecureAuthSystem/login.php"); // Redirect to login if session is not set
    exit();
}

$user_name = $_SESSION['user_name'];

// Database connection
$conn = new mysqli("localhost", "root", "Rohan15@", "bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$sql = "SELECT * FROM users WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - RSD Bank</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            height: 100vh;
            width: 100%;
            background: #f4f4f4 url('RDS/resources/images/bg.png') no-repeat center center;
            color: var(--color);
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #000000;
            display: inline-block;
        }
        .button {
            padding: 10px 20px;
            background: #f67c92;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Gender: <?php echo htmlspecialchars($user['gender']); ?></p>
    <p>Balance: $<?php echo number_format($user['balance'], 2); ?></p>
    <br>
    <a href="dashboard.php" class="button">Go to Dashboard</a>
    <a href="logout.php" class="button">Logout</a>
</div>
</body>
</html>
