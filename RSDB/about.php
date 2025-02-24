<?php
// about.php

// Define stats and values arrays
$stats = [
    ["label" => "Years of Experience", "value" => "25+"],
    ["label" => "Satisfied Customers", "value" => "1M+"],
    ["label" => "Countries Served", "value" => "50+"],
    ["label" => "Digital Transactions", "value" => "₹100B+"],
];

$values = [
    [
        "icon" => "Shield",
        "title" => "Trust & Security",
        "description" => "Your security is our top priority. We employ state-of-the-art encryption and security measures."
    ],
    [
        "icon" => "Users",
        "title" => "Customer First",
        "description" => "We believe in putting our customers first and providing exceptional service at every touchpoint."
    ],
    [
        "icon" => "Trophy",
        "title" => "Excellence",
        "description" => "We strive for excellence in everything we do, from our products to our customer service."
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About RSDB Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://unpkg.com/lucide@latest/dist/lucide.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
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
<body class="bg-gray-50">
<div class="py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="text-center animate__animated animate__fadeInUp">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">About RSDB Bank</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We're more than just a bank. We're your partner in financial success, committed to providing innovative solutions and exceptional service.
            </p>
        </div>

        <!-- Stats Section -->
        <div class="mt-16 grid grid-cols-2 gap-4 sm:grid-cols-4 animate__animated animate__fadeInUp">
            <?php foreach ($stats as $stat): ?>
                <div class="bg-white p-6 rounded-lg shadow-sm text-center animate__animated animate__fadeInUp">
                    <div class="text-3xl font-bold text-pink-500"><?php echo $stat["value"]; ?></div>
                    <div class="text-sm text-gray-600 mt-1"><?php echo $stat["label"]; ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Values Section -->
        <div class="mt-20 animate__animated animate__fadeInUp">
            <h2 class="text-3xl font-bold text-center mb-12">Our Values</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach ($values as $value): ?>
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center animate__animated animate__fadeInUp">
                        <i data-lucide="<?php echo strtolower($value["icon"]); ?>" class="w-12 h-12 text-pink-500 mx-auto mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2"><?php echo $value["title"]; ?></h3>
                        <p class="text-gray-600"><?php echo $value["description"]; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Lucide Icons and Animation Scripts -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons(); // Initialize Lucide icons
</script>
</body>
</html>