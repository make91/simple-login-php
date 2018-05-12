<?php
session_start();
if (!isset($_SESSION['loggedin'])){
	header ( "location: login.php" );
	exit ();
} else if (isset($_POST["logoutButton"])) {
	unset ( $_SESSION ['username'] );
	unset ( $_SESSION ['loggedin'] );
	unset ( $_SESSION ['secretnumber'] );
	$_SESSION['loggedout'] = true;
	header ( "location: login.php" );
	exit ();
}
?>
<!doctype html>
<html>
<head>
<title>Login success</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="PHP login form">
<meta name="author" content="Marcus Kivi">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
	<div class="login-form">
		<form method="post">
			<h2 class="text-center">Hello <?php echo $_SESSION['username']?>!</h2>
			<div class="well">Secret number: <?php echo $_SESSION ['secretnumber'] ?></div>
			<div class="form-group">
				<input type="submit" name="logoutButton" class="btn btn-primary btn-block" value="Log out">
			</div>  
		</form>
    </div>
</div>
</body>
</html>
