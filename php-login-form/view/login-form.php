<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User Login</title>
<link href="./view/css/form.css" rel="stylesheet" type="text/css" />
<style>
body {
	font-family: Arial;
	color: #333;
	font-size: 0.95em;
	background-image: url("./view/images/bg.jpeg");
}
</style>
</head>
<body>
	<div>
		<form action="login-action.php" method="post" id="frmLogin"
			onSubmit="return validate();">
			<div class="login-form-container">

				<div class="form-head">Login</div>
                <?php
                if (isset($_SESSION["errorMessage"])) {
                    ?>
                <div class="error-message"><?php  echo $_SESSION["errorMessage"]; ?></div>
                <?php
                    unset($_SESSION["errorMessage"]);
                }
                ?>
                <div class="field-column">
					<div>
						<label for="username">Username</label><span id="user_info"
							class="error-info"></span>
					</div>
					<div>
						<input name="user_name" id="user_name" type="text"
							class="demo-input-box" placeholder="Enter Username or Email">
					</div>
				</div>
				<div class="field-column">
					<div>
						<label for="password">Password</label><span id="password_info"
							class="error-info"></span>
					</div>
					<div>
						<input name="password" id="password" type="password"
							class="demo-input-box" placeholder="Enter Password">
					</div>
				</div>
				<div class=field-column>
					<div>
						<input type="submit" name="login" value="Login" class="btnLogin"></span>
					</div>
				</div>
				<div class="form-nav-row">
					<a href="#" class="form-link">Forgot password?</a>
				</div>
				<div class="login-row form-nav-row">
					<p>New user?</p>
					<a href="#" class="btn form-link">Signup Now</a>
				</div>
				<div class="login-row form-nav-row">
					<p>May also signup with</p>
					<a href="#"><img src="RDS/php-login-form/view/images/icon-facebook.jpeg"
						class="signup-icon" /></a><a href="#"><img
						src="RDS/php-login-form/view/images/icon-twitter.jpeg" class="signup-icon" /></a><a
						href="#"><img src="RDS/php-login-form/view/images/icon-linkedln.jpeg"
						class="signup-icon" /></a>
				</div>
			</div>
		</form>
	</div>
	<script>
    function validate() {
        var $valid = true;
        document.getElementById("user_info").innerHTML = "";
        document.getElementById("password_info").innerHTML = "";
        
        var userName = document.getElementById("user_name").value;
        var password = document.getElementById("password").value;
        if(userName == "") 
        {
            document.getElementById("user_info").innerHTML = "required";
        	$valid = false;
        }
        if(password == "") 
        {
        	document.getElementById("password_info").innerHTML = "required";
            $valid = false;
        }
        return $valid;
    }
    </script>
</body>
</html>