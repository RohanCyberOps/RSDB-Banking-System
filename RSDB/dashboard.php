<?php
global $conn;
session_start();

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}
$user_id = $_SESSION['user_id'];

include './RDS/Pay/config.php'; // Database connection
if (!$conn) {
    die("Database connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$user = $stmt->get_result()->fetch_assoc();

// Pagination logic
$transactions_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $transactions_per_page;

$transactions_sql = "SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($transactions_sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("iii", $user_id, $transactions_per_page, $offset);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$transactions = $stmt->get_result();

// Calculate total pages
$total_transactions_sql = "SELECT COUNT(*) as total FROM transactions WHERE user_id = ?";
$stmt = $conn->prepare($total_transactions_sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$total_transactions = $stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_transactions / $transactions_per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./SecureAuthSystem/style.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
        </div>
        <div class="card-body">
            <p class="lead">Account Balance: <strong>$<?php echo number_format($user['balance'], 2); ?></strong></p>

            <h3 class="mt-4">Recent Transactions</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Type</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($transactions->num_rows > 0) { ?>
                    <?php while ($transaction = $transactions->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['description']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['type']); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center">No transactions found.</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Transaction navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1) { ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        </li>
                    <?php } ?>
                    <?php if ($page < $total_pages) { ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
                    <?php } ?>
                </ul>
            </nav>

            <!-- Actions -->
            <div class="actions mt-4">
                <a href="RDS/Pay/deposit.php" class="btn btn-success me-2">Deposit Money</a>
                <a href="RDS/Pay/withdraw.php" class="btn btn-warning me-2">Withdraw Money</a>
                <a href="RDS/Pay/transfer.php" class="btn btn-info me-2">Transfer Funds</a>
                <a href="./logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>