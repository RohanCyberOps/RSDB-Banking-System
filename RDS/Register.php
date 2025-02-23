<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a random CSRF token
}

function validatePassword($password) {
    // Minimum 8 characters, at least one uppercase, one lowercase, one number, and one special character
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    return preg_match($pattern, $password);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> Invalid CSRF token. Please try again.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        return;
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $balance = $_POST['balance'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($name) || empty($email) || empty($gender) || empty($balance) || empty($username) || empty($password)) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> All fields are required!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> Invalid email format.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    } elseif ($balance < 0) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> Balance must be a positive number.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    } elseif (!validatePassword($password)) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    } else {
        // Database connection
        $servername = "localhost";
        $username_db = "root";
        $password_db = "Rohan15@";
        $database = "bank";

        $conn = mysqli_connect($servername, $username_db, $password_db, $database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if email already exists
        $sql = "SELECT email FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error!</strong> Email already exists. Please use a different email.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return;
        }

        mysqli_stmt_close($stmt);

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $sql = "INSERT INTO `users` (`name`, `email`, `gender`, `balance`, `password`, `username`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        $created_at = date('Y-m-d H:i:s');
        mysqli_stmt_bind_param($stmt, "sssisss", $name, $email, $gender, $balance, $hashedPassword, $username, $created_at);

        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> User created successfully!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error!</strong> Failed to create user. Please try again.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

    <title>Create User</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Gabriela&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        * {
            box-sizing: border-box;
        }
        .row {
            background: white;
            border-radius: 30px;
            box-shadow: 12px 12px 12px rgba(0, 0, 0, 0.1);
        }
        .login img {
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
        }
        .login h1 {
            font-size: 3rem;
            font-weight: 400;
            font-family: 'Anton', sans-serif;
            font-family: 'Gabriela', serif;
        }
        .inp {
            height: 50px;
            width: 100%;
            border: none;
            outline: none;
            border-radius: 60px;
            box-shadow: -1px 1px 30px -11px rgba(192, 109, 157, 0.5);
            padding: 0 20px;
            margin: 10px 0;
        }
        .btn1 {
            height: 50px;
            width: 100%;
            border: none;
            outline: none;
            border-radius: 60px;
            font-weight: 600;
            background: rgb(223, 56, 56);
            color: white;
            cursor: pointer;
        }
        .btn1:hover {
            background: rgb(143, 61, 61);
            transition: 0.5s;
        }
        #sideNav {
            width: 250px;
            height: 100vh;
            position: fixed;
            right: -250px;
            top: 0;
            background: #863544;
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
        }
        #menuBtn {
            width: 50px;
            position: fixed;
            right: 65px;
            top: 35px;
            z-index: 2;
            cursor: pointer;
        }
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .form-container {
            padding: 20px;
        }
    </style>
</head>
<body>
<section class="login py-5 bg-light">
    <img src="resources/images/menu.png" id="menuBtn">
    <div class="container pt-3">
        <div class="row g-0 pt-5">
            <div class="ps-5 pt-5 mt-5 col-lg-5">
                <img src="resources/images/customers.png" class="img-fluid" alt="Customer Image">
            </div>
            <div class="col-lg-7 text-center py-5">
                <h1>Create New User</h1>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="form-group">
                        <input type="text" name="name" class="inp" placeholder="Full Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="inp" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" class="inp" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="inp" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <select name="gender" class="inp form-select" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" name="balance" class="inp" placeholder="Balance" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn1">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<nav id="sideNav">
    <ul>
        <li><a href="main.html">HOME</a></li>
        <li><a href="users.php">OUR CUSTOMERS</a></li>
        <li><a href="history.php">TRANSACTION HISTORY</a></li>
        <li><a href="users.php">TRANSFER MONEY</a></li>
        <li><a href="Register.php">NEW USER</a></li>
    </ul>
</nav>

<script>
    let menuBtn = document.querySelector('#menuBtn');
    let sideNav = document.querySelector('#sideNav');
    let condition = true;

    menuBtn.addEventListener('click', function () {
        if (condition) {
            sideNav.style.right = '0px';
            condition = false;
        } else {
            sideNav.style.right = '-250px';
            condition = true;
        }
    });

    // Password strength validation
    const passwordInput = document.querySelector('input[name="password"]');
    passwordInput.addEventListener('input', function () {
        const password = this.value;
        const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (pattern.test(password)) {
            this.style.borderColor = 'green';
        } else {
            this.style.borderColor = 'red';
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
</html>