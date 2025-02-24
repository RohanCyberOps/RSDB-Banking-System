<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if (!$name || !$email || !$message) {
        $error = "All fields are required and must be valid.";
    } else {
        // Send email (Modify this as needed for SMTP)
        $to = "support@yourbank.com"; // Replace with your support email
        $subject = "New Contact Form Message";
        $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";

        $body = "Name: $name\nEmail: $email\nMessage:\n$message";

        if (mail($to, $subject, $body, $headers)) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Failed to send message. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>/* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
        margin: 0;
        padding: 0;
        height: 100vh;
        width: 100%;
        background: url('./RDS/resources/images/bg.png') no-repeat center center/cover;
        color: var(--color);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        background-color: #fff;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background-color: #ea0aa0;
        color: white;
        border-radius: 10px 10px 0 0;
        padding: 15px;
        text-align: center;
    }

    .card-title {
        margin: 0;
        font-size: 1.5rem;
    }

    .card-body {
        padding: 20px;
    }

    /* Button Styles */
    .btn {
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 1rem;
        transition: background-color 0.2s, transform 0.2s;
        text-align: center;
        display: inline-block;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #ea0aa0;
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background-color: rgba(234, 10, 160, 0.71);
        transform: translateY(-2px);
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: black;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }

    .btn-lg {
        padding: 15px 30px;
        font-size: 1.25rem;
    }

    /* Form Styles */
    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 10px;
        font-size: 1rem;
        width: 100%;
        margin-bottom: 15px;
    }

    .form-control:focus {
        border-color: #ea0aa0;
        box-shadow: 0 0 5px rgba(234, 10, 160, 0.71);
    }

    .form-label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
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
        text-align: center;
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
        border-color: rgba(234, 10, 160, 0.71);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .btn-lg {
            width: 100%;
            margin-bottom: 10px;
        }

        .card {
            margin-bottom: 20px;
        }
    }
</style>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="card-title">Contact Us</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"> <?= $error ?> </div>
            <?php elseif (!empty($success)): ?>
                <div class="alert alert-success"> <?= $success ?> </div>
            <?php endif; ?>

            <form method="POST" action="./Contact.php">
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
