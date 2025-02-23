<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Money</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert for success/error messages -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .form-container label {
            font-weight: 500;
        }
        .form-container input, .form-container select {
            margin-bottom: 15px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
            display: none;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Transfer Money</h2>
    <form id="transferForm" action="transfer.php" method="POST">
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <!-- Receiver's Name (Dropdown) -->
        <div class="mb-3">
            <label for="receiver" class="form-label">Receiver's Name</label>
            <select class="form-control" id="receiver" name="receiver" required>
                <option value="">Select Receiver</option>
                <!-- Options will be dynamically loaded via AJAX -->
            </select>
        </div>

        <!-- Amount -->
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" min="1" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary" id="submitBtn">Transfer</button>
        <div class="loader" id="loader"></div>
    </form>
</div>

<!-- Bootstrap JS (Optional, for interactive components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Client-Side Validation and SweetAlert for Messages -->
<script>
    // Load receivers dynamically via AJAX
    document.addEventListener('DOMContentLoaded', function () {
        fetch('../getReceivers.php') // Replace with your backend endpoint
            .then(response => response.json())
            .then(data => {
                const receiverSelect = document.getElementById('receiver');
                receiverSelect.innerHTML = '<option value="">Select Receiver</option>';
                data.forEach(receiver => {
                    const option = document.createElement('option');
                    option.value = receiver.id;
                    option.textContent = receiver.name;
                    receiverSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading receivers:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load receivers. Please try again later.',
                });
            });
    });

    // Form submission handling
    document.getElementById('transferForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        const amount = document.getElementById('amount').value;
        const receiver = document.getElementById('receiver').value;

        // Validate amount
        if (amount <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Amount',
                text: 'Amount must be greater than 0.',
            });
            return;
        }

        // Validate receiver
        if (!receiver) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Receiver',
                text: 'Please select a receiver.',
            });
            return;
        }

        // Show confirmation dialog
        Swal.fire({
            title: 'Confirm Transfer',
            text: `Are you sure you want to transfer $${amount}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Transfer',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loader
                document.getElementById('submitBtn').style.display = 'none';
                document.getElementById('loader').style.display = 'block';

                // Submit the form via AJAX
                const formData = new FormData(document.getElementById('transferForm'));
                fetch('../transfer.php', {
                    method: 'POST',
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        // Hide loader
                        document.getElementById('submitBtn').style.display = 'block';
                        document.getElementById('loader').style.display = 'none';

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Transfer Successful',
                                text: data.message || 'The transaction was completed successfully.',
                            }).then(() => {
                                window.location.reload(); // Reload the page
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Transfer Failed',
                                text: data.message || 'An error occurred during the transaction.',
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred. Please try again later.',
                        });
                    });
            }
        });
    });

    // Display success/error messages from PHP (if any)
    <?php if (isset($_GET['message'])): ?>
    <?php if ($_GET['message'] === 'success'): ?>
    Swal.fire({
        icon: 'success',
        title: 'Transfer Successful',
        text: 'The transaction was completed successfully.',
    });
    <?php elseif ($_GET['message'] === 'transactionDenied'): ?>
    Swal.fire({
        icon: 'error',
        title: 'Transfer Denied',
        text: 'Insufficient balance or invalid transaction.',
    });
    <?php endif; ?>
    <?php endif; ?>
</script>
</body>
</html>