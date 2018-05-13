<?php
session_start();
unset ( $_SESSION['fromIndex'] );
if (!isset($_SESSION['loggedin'])){
	if (isset($_COOKIE['remember-me'])) {
		$hash = $_COOKIE['remember-me'];
		$link = mysqli_connect("localhost", "root", "asdf", "test");
		if ($link) {
			$stmt = mysqli_prepare($link, "SELECT hash, user_id, ip FROM persistent_logins1 WHERE hash=?");
			mysqli_stmt_bind_param($stmt, "s", $_COOKIE['remember-me']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $hashFromDB, $useridFromDB, $ipFromDB);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			$clientIP = include 'getIP.php';
			if ($hash == $hashFromDB && $clientIP == $ipFromDB) {
				$stmt = mysqli_prepare($link, "SELECT username FROM user_test1 WHERE id=?");
				mysqli_stmt_bind_param($stmt, "i", $useridFromDB);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $usernameFromDB);
				mysqli_stmt_fetch($stmt);
				mysqli_stmt_close($stmt);
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['secretnumber'] = sprintf("%09d", rand(0, 999999999));
				$_SESSION['username'] = $usernameFromDB;
			} else {
				$_SESSION['fromIndex'] = TRUE;
				header ( "location: login.php" );
				exit ();
			}
		}
		mysqli_close($link);
	} else {
		header ( "location: login.php" );
		exit ();
	}
} else if (isset($_POST["logoutButton"])) {
	if (isset($_COOKIE['remember-me'])) {
		$link = mysqli_connect("localhost", "root", "asdf", "test");
		if ($link) {
			$stmt = mysqli_prepare($link, "DELETE FROM persistent_logins1 WHERE hash=?");
			mysqli_stmt_bind_param($stmt, "s", $_COOKIE['remember-me']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		mysqli_close($link);
		unset($_COOKIE['remember-me']);
		setcookie('remember-me', null, -1, '/');
	}
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
