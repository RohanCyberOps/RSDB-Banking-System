<?php
global $conn;
session_start();

include 'db_connect.php'; // Include database connection

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $from_acc_number = $_POST['from_acc_number'];
    $to_acc_number = $_POST['to_acc_number'];
    $amount = floatval($_POST['amount']);

    // Validate transfer amount
    if ($amount <= 0) {
        $error = "Invalid transfer amount!";
    } else {
        // Check if the sender's account exists and fetch the current balance
        $check_sender_sql = "SELECT balance FROM accounts WHERE account_no = ?";
        $stmt = $conn->prepare($check_sender_sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $from_acc_number);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($sender_balance);
            $stmt->fetch();

            // Check if the sender's account has sufficient balance
            if ($amount > $sender_balance) {
                $error = "Insufficient funds!";
            } else {
                // Check if the receiver's account exists
                $check_receiver_sql = "SELECT balance FROM accounts WHERE account_no = ?";
                $receiver_stmt = $conn->prepare($check_receiver_sql);
                if (!$receiver_stmt) {
                    die("Prepare failed: " . $conn->error);
                }
                $receiver_stmt->bind_param("s", $to_acc_number);
                if (!$receiver_stmt->execute()) {
                    die("Execute failed: " . $receiver_stmt->error);
                }
                $receiver_stmt->store_result();

                if ($receiver_stmt->num_rows > 0) {
                    $receiver_stmt->bind_result($receiver_balance);
                    $receiver_stmt->fetch();

                    // Calculate new balances
                    $new_sender_balance = $sender_balance - $amount;
                    $new_receiver_balance = $receiver_balance + $amount;

                    // Update sender's balance
                    $update_sender_sql = "UPDATE accounts SET balance = ? WHERE account_no = ?";
                    $update_sender_stmt = $conn->prepare($update_sender_sql);
                    if (!$update_sender_stmt) {
                        die("Prepare failed: " . $conn->error);
                    }
                    $update_sender_stmt->bind_param("ds", $new_sender_balance, $from_acc_number);
                    if (!$update_sender_stmt->execute()) {
                        die("Execute failed: " . $update_sender_stmt->error);
                    }

                    // Update receiver's balance
                    $update_receiver_sql = "UPDATE accounts SET balance = ? WHERE account_no = ?";
                    $update_receiver_stmt = $conn->prepare($update_receiver_sql);
                    if (!$update_receiver_stmt) {
                        die("Prepare failed: " . $conn->error);
                    }
                    $update_receiver_stmt->bind_param("ds", $new_receiver_balance, $to_acc_number);
                    if (!$update_receiver_stmt->execute()) {
                        die("Execute failed: " . $update_receiver_stmt->error);
                    }

                    // Insert transaction record for sender
                    $txn_id_sender = uniqid("TXN");
                    $txn_sender_sql = "INSERT INTO transactions (sender_user_id, sender_name, receiver_user_id, receiver_name, sender_account_no, receiver_account_no, transaction_id, type, transaction_amount, role) VALUES (?, ?, ?, ?, ?, ?, ?, 'Transfer', ?, 'sender')";
                    $txn_sender_stmt = $conn->prepare($txn_sender_sql);
                    if (!$txn_sender_stmt) {
                        die("Prepare failed: " . $conn->error);
                    }
                    $txn_sender_stmt->bind_param("sssd", $from_acc_number, $to_acc_number, $txn_id_sender, $amount);
                    if (!$txn_sender_stmt->execute()) {
                        die("Execute failed: " . $txn_sender_stmt->error);
                    }

                    // Insert transaction record for receiver
                    $txn_id_receiver = uniqid("TXN");
                    $txn_receiver_sql = "INSERT INTO transactions ( sender_user_id, sender_name, receiver_user_id, receiver_name, sender_account_no, receiver_account_no, transaction_id, type, transaction_amount, role) VALUES (?, ?, ?, ?, ?, ?, ?, 'Transfer', ?, 'sender')";
                    $txn_receiver_stmt = $conn->prepare($txn_receiver_sql);
                    if (!$txn_receiver_stmt) {
                        die("Prepare failed: " . $conn->error);
                    }
                    $txn_receiver_stmt->bind_param("sssd", $from_acc_number, $to_acc_number, $txn_id_receiver, $amount);
                    if (!$txn_receiver_stmt->execute()) {
                        die("Execute failed: " . $txn_receiver_stmt->error);
                    }

                    $success = "Transfer successful! New Balance: ₹" . number_format($new_sender_balance, 2);
                } else {
                    $error = "Receiver's account not found!";
                }

                $receiver_stmt->close();
            }
        } else {
            $error = "Sender's account not found!";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
        height: 100vh;
        width: 100%;
        background: url('../resources/images/bg.png') no-repeat center center/cover;
        color: var(--color);
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    /* Card Styles */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-header {
        background-color: #ffffff; /* Pink color */
        color: white;
        border-radius: 10px 10px 0 0;
        padding: 15px;
    }
    .card-title {
        margin: 0;
        font-size: 1.5rem;
    }
    .card-body {
        padding: 20px;
    }
    /* Form Styles */
    .form-label {
        font-weight: bold;
        margin-bottom: 5px;
    }
    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 10px;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #ea0aa0;
        box-shadow: 0 0 5px rgba(234, 10, 160, 0.71);
    }
    .btn {
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 1rem;
        transition: background-color 0.2s;
    }
    .btn-primary {
        background-color: #ea0aa0;
        border: none;
    }
    .btn-primary:hover {
        background-color: rgba(234, 10, 160, 0.71);
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    .btn-warning {
        background-color: #ffc107;
        border: none;
    }
    .btn-warning:hover {
        background-color: #e0a800;
    }
    /* Alert Styles */
    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-pink text-black">
            <h2 class="card-title">Transfer Money</h2>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-3">
                    <label for="from_acc_number" class="form-label">From Account Number</label>
                    <input type="text" class="form-control" id="from_acc_number" name="from_acc_number" required>
                </div>
                <div class="mb-3">
                    <label for="to_acc_number" class="form-label">To Account Number</label>
                    <input type="text" class="form-control" id="to_acc_number" name="to_acc_number" required>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Transfer</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>