<?php
session_start(); // Start the session

// Debugging: Print session and POST data
echo "<pre>";
echo "Sender (from session): " . ($_SESSION['sender'] ?? 'Not set') . "\n";
echo "Receiver (from POST): " . ($_POST['receiver'] ?? 'Not set') . "\n";
echo "Amount (from POST): " . ($_POST['amount'] ?? 'Not set') . "\n";
echo "</pre>";

// Validate sender
if (!isset($_SESSION['sender'])) {
    die("Sender not set in session. Please log in or select a sender.");
}

// Database connection
$server = "localhost";
$username = "root";
$password = "Rohan15@";
$con = mysqli_connect($server, $username, $password, "bank");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$flag = false;
$sender = $_SESSION['sender']; // Sender is set in the session
$receiver = $_POST["receiver"] ?? null;
$amount = $_POST["amount"] ?? null;

// Validate receiver and amount
if (!$receiver) {
    die("Receiver not provided.");
}
if (!$amount || $amount <= 0) {
    die("Invalid amount. Amount must be a positive number.");
}

// Start transaction
mysqli_begin_transaction($con);

try {
    // Check if the sender has sufficient balance
    $sql = "SELECT Balance FROM users WHERE name = ? FOR UPDATE";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $sender);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($amount > $row["Balance"] || $row["Balance"] - $amount < 100) {
            $location = 'Details.php?user=' . $sender;
            header("Location: $location&message=transactionDenied");
            exit();
        }
    } else {
        die("Sender not found.");
    }

    // Deduct amount from sender's balance
    $sql = "UPDATE users SET Balance = Balance - ? WHERE Name = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ds", $amount, $sender);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error updating sender's balance: " . mysqli_error($con));
    }
    mysqli_stmt_close($stmt);

    // Add amount to receiver's balance
    $sql = "UPDATE users SET Balance = Balance + ? WHERE name = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ds", $amount, $receiver);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error updating receiver's balance: " . mysqli_error($con));
    }
    mysqli_stmt_close($stmt);

    // Record the transaction
    // Get sender's account number
    $sql = "SELECT Acc_Number FROM users WHERE name = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $sender);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $s_acc = $result->fetch_assoc()['Acc_Number'];
    mysqli_stmt_close($stmt);

    // Get receiver's account number
    $sql = "SELECT Acc_Number FROM users WHERE name = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $receiver);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $r_acc = $result->fetch_assoc()['Acc_Number'];
    mysqli_stmt_close($stmt);

    // Insert transaction into transfer table
    $sql = "INSERT INTO transactions
        (sender_user_id, receiver_user_id, transaction_amount, sender_account_no, receiver_account_no)
        VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssdds", $sender, $receiver, $amount, $s_acc, $r_acc);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error recording transaction: " . mysqli_error($con));
    }
    mysqli_stmt_close($stmt);

    // Commit transaction
    mysqli_commit($con);
    $flag = true;
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($con);
    die($e->getMessage());
}

// Redirect to details page with success message
$location = 'Details.php?user=' . $sender;
header("Location: $location&message=success");
exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Bank Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="resources/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #2b67f8;
        }
        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child) {
                display: none;
            }
            .topnav a.icon {
                float: right;
                display: block;
            }
        }
        @media screen and (max-width: 400px) {
            .topnav.responsive {
                position: relative;
            }
            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
            .topnav.responsive .dropdown {
                float: none;
            }
            .topnav.responsive .dropdown-content {
                position: relative;
            }
            .topnav.responsive .dropdown .dropbtn {
                display: block;
                width: 100%;
                text-align: left;
            }
        }
    </style>
</head>
<body>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (Required for Bootstrap) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</body>
</html>