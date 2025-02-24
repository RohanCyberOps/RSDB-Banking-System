<!DOCTYPE html>
<html>
<head>
<title>Transaction history</title>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Gabriela&display=swap" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            width: 100%;
            background: url('RDS/resources/images/bg.png') no-repeat center center/cover;
            color: var(--color);
        }

        table {
            border-collapse: collapse;
            width: 100%;
            color:black;
            font-size: 25px;
            text-align: left;
        }
        th {
            background-color: #ea0aa0;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2}

        #sideNav{
            width: 250px;
            height: 100vh;
            position: fixed;
            right: -250px;
            top:0;
            background: #ea0aa0;
            z-index: 2;
            transition: .5s;
        }
        nav ul li{
            list-style: none;
            margin: 50px 20px;
        }
        nav ul li a{
            text-decoration: none;
            color: #fff;
        }
        #menuBtn{
            width: 50px;
            position: fixed;
            right: 65px;
            top: 35px;
            z-index: 2;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div style="font-family: 'Gabriela', serif;   font-size: 40px;
        text-align: center;
        margin: 20px;
    }">Transaction History</div>
    <table>
    <tr>
    <th>Sender's Name</th>
    <th>Sender's Account</th>
    <th>Reciever's Name</th>
    <th>Reciever's Account </th>
    <th>Amount</th>
    <th>Date and Time</th>
    </tr>

    <?php
        // Connecting to the Database
        $servername = "localhost";
        $username = "root";
        $password = "Rohan15@";
        $database = "bank";

        // Create a connection
        $conn = mysqli_connect($servername, $username, $password, $database);
        // Die if connection was not successful
        if (!$conn){
            die("Sorry we failed to connect: ". mysqli_connect_error());
        }


        $sql = "SELECT * FROM transactions";
        $result = mysqli_query($conn, $sql);

        // Find the number of records returned
        $num = mysqli_num_rows($result);

        // Display the rows returned by the sql query
        if($num> 0){
            

            // We can fetch in a better way using the while loop
            while($row = mysqli_fetch_assoc($result)){
                // echo var_dump($row);
                echo "<tr>";
                echo "<td>" . $row["sender_user_id"]. "</td><td>" . $row["sender_account_no"] . "</td>
                <td>" . $row["receiver_user_id"] . "</td><td>" . $row["receiver_account_no"] . "</td><td>" . $row["transaction_amount"] . "</td><td>" . $row["created_at"] . "</td>";
                 echo "</tr>";
        }
        echo "</table>";
        }
    ?>


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
        <img src="RDS/resources/images/menu.png" id="menuBtn">
    </div>

    <script>
        let menuBtn = document.querySelector('#hojaplz');
        let sideNav = document.querySelector('#sideNav')
        let condition = true;
        menuBtn.addEventListener('click',function(){
            if(condition){
                 sideNav.style.right = '0px';
                 condition = false;
            }
            else{
                sideNav.style.right = '-250px';
                condition = true;
            }
            })
    </script>
    </table>
    </body>
</html>