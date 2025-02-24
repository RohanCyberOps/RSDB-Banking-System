<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Application</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Gabriela&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Gabriela', serif;
            margin: 0;
            padding: 0;
            background-image: url('RDS/resources/images/background.png'); /* Add background image */
            background-size: cover; /* Ensure the image covers the entire background */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            background-attachment: fixed; /* Fix the background image while scrolling */
            background-color: #ea0aa0; /* Fallback background color */
        }

        table {
            border-collapse: collapse;
            width: 100%;
            color: black;
            font-size: 25px;
            text-align: left;
            margin-bottom: 20px;
        }

        th {
            background: #ea0aa0;
            color: white;
            padding: 10px;
        }

        td {
            padding: 10px;
        }

        tr:nth-child(even) {
            background-color: rgba(242, 242, 242, 0.8); /* Add transparency to table rows */
        }

        #sideNav {
            width: 250px;
            height: 100vh;
            position: fixed;
            right: -250px;
            top: 0;
            background: #ea0aa0;
            z-index: 2;
            transition: 0.5s;
        }

        nav ul li {
            list-style: none;
            margin: 50px 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
        }

        #menuBtn {
            width: 50px;
            position: fixed;
            right: 65px;
            top: 35px;
            z-index: 2;
            cursor: pointer;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            text-align: center;
            background: rgba(250, 235, 215, 0.9); /* Add transparency to card background */
            padding: 20px;
            margin: 40px auto;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .container {
            padding: 20px;
        }

        .messagehide {
            margin: 10px 0;
        }

        .textbox {
            padding: 8px;
            width: 100%;
            max-width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: rgba(243, 70, 186, 0.71);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgba(234, 10, 160, 0.71);
        }

        h3 {
            font-size: 40px;
            text-align: center;
            margin: 20px 0;
            color: white; /* Change text color for better visibility */
        }
    </style>
</head>
<body>
<!-- Table for Account Details -->
<table>
    <tr>
        <th>Account Number</th>
        <th>Name</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Balance</th>
    </tr>
    <?php
    session_start();
    $server = "localhost";
    $username = "root";
    $password = "Rohan15@";
    $dbname = "bank";

    // Create connection
    $conn = mysqli_connect($server, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize and set session variables
    if (isset($_GET['user'])) {
        $_SESSION['user'] = htmlspecialchars($_GET['user'], ENT_QUOTES, 'UTF-8');
        $_SESSION['sender'] = $_SESSION['user'];
    }

    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $sql = "SELECT * FROM users WHERE Name=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["Acc_Number"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row["Name"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row["Email Id"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row["Gender"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row["Balance"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>

<!-- Make a Transaction Section -->
<h3>Make a Transaction</h3>
<div class="card">
    <?php
    if (isset($_GET['message'])) {
        if ($_GET['message'] == 'success') {
            echo "<h3><p style='color:green;' class='messagehide'>Transaction was completed successfully</p></h3>";
        } elseif ($_GET['message'] == 'transactionDenied') {
            echo "<h3><p style='color:red;' class='messagehide'>Transaction Failed</p></h3>";
        }
    }
    ?>
    <form action="transfer.php" method="POST">
        <label for="recipient"><b>To:</b></label>
        <select name="reciever" id="recipient" class="textbox" required>
            <option value="">Select Recipient</option>
            <?php
            $res = $conn->prepare("SELECT * FROM users WHERE name != ?");
            $res->bind_param("s", $user);
            $res->execute();
            $recipientResult = $res->get_result();
            while ($row = $recipientResult->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8') . "</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="sender"><b>From:</b></label>
        <input type="text" id="sender" name="sender" class="textbox" value="<?= htmlspecialchars($user, ENT_QUOTES, 'UTF-8') ?>" readonly>
        <br><br>
        <label for="amount"><b>Amount (₹):</b></label>
        <input type="number" id="amount" name="amount" class="textbox" min="100" required>
        <br><br>
        <button type="submit" name="transfer">Transfer</button>
    </form>
</div>

<!-- Customer Details Section -->
<h3>Customer Details</h3>

<!-- Side Navigation -->
<nav id="sideNav">
    <ul>
        <li><a href="main.html">HOME</a></li>
        <li><a href="users.php">OUR CUSTOMERS</a></li>
        <li><a href="history.php">TRANSACTION HISTORY</a></li>
        <li><a href="TransferMoney.php">TRANSFER MONEY</a></li>
        <li><a href="Register.php">NEW USER</a></li>
        <li><a href="Contact.php">CONTACT</a></li>
        <li><a href="about.php">ABOUT</a></li>
        <li><a href="Service.php">SERVICE</a></li>
        <li><a href="Online.php">ONLINE BANKING</a></li>
        <li><a href="./SecureAuthSystem/login.php">LOGIN</a></li>
    </ul>
</nav>
<div id="hojaplz">
    <img src="RDS/resources/images/menu.png" id="menuBtn" alt="Menu">
</div>

<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script>
    let menuBtn = document.querySelector('#hojaplz');
    let sideNav = document.querySelector('#sideNav');
    let condition = true;

    menuBtn.addEventListener('click', function() {
        if (condition) {
            sideNav.style.right = '0px';
            condition = false;
        } else {
            sideNav.style.right = '-250px';
            condition = true;
        }
    });

    $(function() {
        setTimeout(function() {
            $('.messagehide').fadeOut('slow');
        }, 3000);
    });
</script>
</body>
</html>