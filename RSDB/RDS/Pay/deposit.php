<?php
global $conn;
include 'db_connect.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // Process form data
    $acc_number = $_POST['acc_number'];
    $amount = floatval($_POST['amount']);

    // Validate deposit amount
    if ($amount <= 0) {
        echo "<div class='alert alert-danger'>Invalid deposit amount!</div>";
        exit;
    }

    // Check if the account exists
    $check_sql = "SELECT balance FROM accounts WHERE account_no = ?";
    $stmt = $conn->prepare($check_sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $acc_number);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($balance);
        $stmt->fetch();
        $new_balance = $balance + $amount;

        // Update balance
        $update_sql = "UPDATE accounts SET balance = ? WHERE account_no = ?";
        $update_stmt = $conn->prepare($update_sql);
        if (!$update_stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $update_stmt->bind_param("ds", $new_balance, $acc_number);
        if (!$update_stmt->execute()) {
            die("Execute failed: " . $update_stmt->error);
        }

        // Insert transaction record
        $txn_id = uniqid("TXN");
        $txn_sql = "INSERT INTO transactions (receiver_account_no, transaction_id, type, transaction_amount) VALUES (?, ?, 'Deposit', ?)";
        $txn_stmt = $conn->prepare($txn_sql);
        if (!$txn_stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $txn_stmt->bind_param("ssd", $acc_number, $txn_id, $amount);
        if (!$txn_stmt->execute()) {
            die("Execute failed: " . $txn_stmt->error);
        }

        echo "<div class='alert alert-success'>Deposit successful! New Balance: ₹" . number_format($new_balance, 2) . "</div>";
    } else {
        echo "<div class='alert alert-danger'>Account not found!</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>/* General Styles */
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

    /* Table Styles */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #ea0aa0;
        color: white;
    }

    .table tr:hover {
        background-color: #f1f1f1;
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

    /* Pagination Styles */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .page-item {
        margin: 0 5px;
    }

    .page-link {
        color: #ea0aa0;
        border: 1px solid #ea0aa0;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.2s, color 0.2s;
    }

    .page-link:hover {
        background-color: #ea0aa0;
        color: white;
    }

    .page-item.active .page-link {
        background-color: #ea0aa0;
        color: white;
        border-color: #ea0aa0;
    }
</style>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-pink text-black">
            <h2 class="card-title">Deposit Money</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="mb-3">
                    <label for="acc_number" class="form-label">Account Number</label>
                    <input type="text" class="form-control" id="acc_number" name="acc_number" required>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Deposit</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>