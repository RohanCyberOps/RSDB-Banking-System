<?php
namespace Phppot;

use form\class\Member;

if (! empty($_SESSION["userId"])) {
    require_once __DIR__ . './../class/Member.php';
    $member = new form\class\Member();
    $memberResult = $member->getMemberById($_SESSION["userId"]);
    if(!empty($memberResult[0]["display_name"])) {
        $displayName = ucwords($memberResult[0]["display_name"]);
    } else {
        $displayName = $memberResult[0]["user_name"];
    }
}
?>
<html>
<head>
<title>User Login</title>
<style>
body {
	font-family: Arial;
	color: #333;
	font-size: 0.95em;
}

.dashboard {
	background: #d2edd5;
	margin: 15px auto;
	line-height: 1.8em;
	color: #333;
	border-radius: 4px;
	padding: 30px;
	max-width: 400px;
	border: #c8e0cb 1px solid;
	text-align: center;
}

a.logout-button {
	color: #09f;
}
.profile-photo {
    width: 100px;
    border-radius: 50%;
}
</style>
</head>
<body>
    <div>
        <div class="dashboard">
            <div class="member-dashboard">
            <p>Welcome <b><?php echo $displayName; ?>!</b></p>
            <p><?php echo $memberResult[0]["about"]; ?></p>

            <p><img src="/view/images/photo.jpeg" class="profile-photo" /></p>
            <p>You have successfully logged in!</p>
            <p>Click to <a href="./logout.php" class="logout-button">Logout</a></p>
            </div>
        </div>
    </div>
</body>
</html>