<?php
header('Content-Type: application/json');

// Database connection details
$host = 'localhost'; // Replace with your database host
$dbname = 'bank'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = 'Rohan15@'; // Replace with your database password

try {
    // Create a PDO connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch unique receiver names
    $query = "SELECT DISTINCT receiver_name, receiver_user_id FROM transactions";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch results as an associative array
    $receivers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($receivers);
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>