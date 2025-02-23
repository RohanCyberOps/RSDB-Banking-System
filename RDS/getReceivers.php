<?php
// Enable CORS (Cross-Origin Resource Sharing) if needed
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "Rohan15@"; // Replace with your database password
$dbname = "bank"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Fetch receivers from the database
$sql = "SELECT id, name FROM users WHERE role = 'receiver'"; // Adjust query as needed
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit();
}

// Prepare data for JSON response
$receivers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $receivers[] = [
            "id" => $row["id"],
            "name" => $row["name"]
        ];
    }
}

// Close the database connection
$conn->close();

// Return JSON response
http_response_code(200); // OK
echo json_encode($receivers);
?>