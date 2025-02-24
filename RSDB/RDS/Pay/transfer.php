<?php
session_start();
header('Content-Type: application/json');

// Include configuration file
include 'config.php';

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);
    exit;
}

// Validate inputs
$requiredFields = ['sender_user_id', 'sender_name', 'sender_account_no', 'receiver_user_id', 'receiver_name', 'receiver_account_no', 'amount', 'transaction_id'];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }
}

// Sanitize inputs
$senderUserId = intval($_POST['sender_user_id']);
$senderName = htmlspecialchars($_POST['sender_name']);
$senderAccountNo = htmlspecialchars($_POST['sender_account_no']);
$receiverUserId = intval($_POST['receiver_user_id']);
$receiverName = htmlspecialchars($_POST['receiver_name']);
$receiverAccountNo = htmlspecialchars($_POST['receiver_account_no']);
$amount = floatval($_POST['amount']);
$transactionId = htmlspecialchars($_POST['transaction_id']);

// Validate amount
if ($amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid transfer amount.']);
    exit;
}

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin transaction
    $pdo->beginTransaction();

    // Check sender's balance
    $checkBalanceQuery = "SELECT balance FROM accounts WHERE user_id = :sender_user_id AND account_no = :sender_account_no";
    $stmt = $pdo->prepare($checkBalanceQuery);
    $stmt->execute([':sender_user_id' => $senderUserId, ':sender_account_no' => $senderAccountNo]);
    $senderBalance = $stmt->fetchColumn();

    if ($senderBalance === false) {
        echo json_encode(['success' => false, 'message' => 'Sender account not found.']);
        exit;
    }

    if ($senderBalance < $amount) {
        echo json_encode(['success' => false, 'message' => 'Insufficient balance.']);
        exit;
    }

    // Deduct amount from sender's account
    $deductQuery = "UPDATE accounts SET balance = balance - :amount WHERE user_id = :sender_user_id AND account_no = :sender_account_no";
    $stmt = $pdo->prepare($deductQuery);
    $stmt->execute([':amount' => $amount, ':sender_user_id' => $senderUserId, ':sender_account_no' => $senderAccountNo]);

    // Add amount to receiver's account
    $addQuery = "UPDATE accounts SET balance = balance + :amount WHERE user_id = :receiver_user_id AND account_no = :receiver_account_no";
    $stmt = $pdo->prepare($addQuery);
    $stmt->execute([':amount' => $amount, ':receiver_user_id' => $receiverUserId, ':receiver_account_no' => $receiverAccountNo]);

    // Insert transaction into the transactions table
    $insertQuery = "INSERT INTO transactions (
        account_no, sender_user_id, sender_name, receiver_user_id, receiver_name,
        transaction_amount, transaction_id, sender_account_no, receiver_account_no,
        role, type
    ) VALUES (
        :account_no, :sender_user_id, :sender_name, :receiver_user_id, :receiver_name,
        :transaction_amount, :transaction_id, :sender_account_no, :receiver_account_no,
        :role, :type
    )";
    $stmt = $pdo->prepare($insertQuery);
    $stmt->execute([
        ':account_no' => $senderAccountNo,
        ':sender_user_id' => $senderUserId,
        ':sender_name' => $senderName,
        ':receiver_user_id' => $receiverUserId,
        ':receiver_name' => $receiverName,
        ':transaction_amount' => $amount,
        ':transaction_id' => $transactionId,
        ':sender_account_no' => $senderAccountNo,
        ':receiver_account_no' => $receiverAccountNo,
        ':role' => 'sender',
        ':type' => 'Transfer'
    ]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Transfer completed successfully.']);
} catch (PDOException $e) {
    // Rollback transaction on error
    if (isset($pdo)) {
        $pdo->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
