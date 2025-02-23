<form action="process_transaction.php" method="POST">
    <!-- Remove this line -->
    <!-- <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> -->

    <input type="text" name="receiver" placeholder="Receiver's Name" required>
    <input type="number" name="amount" placeholder="Amount" required>
    <button type="submit">Submit</button>
</form>