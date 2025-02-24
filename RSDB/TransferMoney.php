
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your custom CSS -->
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
        background-color: #007bff;
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
        background-color: #007bff;
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
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
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
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
        background-color: #007bff;
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
        color: #007bff;
        border: 1px solid #007bff;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.2s, color 0.2s;
    }

    .page-link:hover {
        background-color: #007bff;
        color: white;
    }

    .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
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
            <h2 class="card-title">Money Operations</h2>
        </div>
        <div class="card-body">
            <div class="text-center">
                <p class="lead">Choose an action to perform:</p>
                <div class="d-grid gap-3">
                    <a href="./RDS/Pay/deposit.php" class="btn btn-success btn-lg">Deposit Money</a>
                    <a href="./RDS/Pay/withdraw.php" class="btn btn-warning btn-lg">Withdraw Money</a>
                    <a href="./RDS/Pay/transfer.php" class="btn btn-info btn-lg">Transfer Funds</a>
                    <a href="dashboard.php" class="btn btn-secondary btn-lg">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // scripts.js

    // Function to validate deposit/withdraw/transfer forms
    function validateForm(event) {
        const amountInput = document.getElementById('amount');
        const amount = parseFloat(amountInput.value);

        if (isNaN(amount) {
            alert("Please enter a valid amount.");
            event.preventDefault();
            return false;
        }

        if (amount <= 0) {
            alert("Amount must be greater than 0.");
            event.preventDefault();
            return false;
        }

        return true;
    }

    // Add event listeners to forms
    document.addEventListener('DOMContentLoaded', function () {
        const depositForm = document.getElementById('deposit-form');
        const withdrawForm = document.getElementById('withdraw-form');
        const transferForm = document.getElementById('transfer-form');

        if (depositForm) {
            depositForm.addEventListener('submit', validateForm);
        }

        if (withdrawForm) {
            withdrawForm.addEventListener('submit', validateForm);
        }

        if (transferForm) {
            transferForm.addEventListener('submit', validateForm);
        }
    });

    // Function to show a confirmation dialog before performing actions
    function confirmAction(action) {
        return confirm(`Are you sure you want to ${action}?`);
    }

    // Add confirmation to logout button
    document.addEventListener('DOMContentLoaded', function () {
        const logoutButton = document.getElementById('logout-button');
        if (logoutButton) {
            logoutButton.addEventListener('click', function (event) {
                if (!confirmAction('logout')) {
                    event.preventDefault();
                }
            });
        }
    });

    // Function to dynamically update the balance on the dashboard
    function updateBalance(newBalance) {
        const balanceElement = document.getElementById('balance');
        if (balanceElement) {
            balanceElement.textContent = `$${newBalance.toFixed(2)}`;
        }
    }
</script>
</body>
</html>