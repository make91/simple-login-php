<?php  //Start the Session
session_start();

if (isset($_POST['username']) && isset($_POST['password'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$_SESSION['username'] = $username;

	$link = mysqli_connect("localhost", "make91", "password", "make91");
	if ($link) {
		$stmt = mysqli_prepare($link, "SELECT password FROM `user_test1` WHERE username=?");
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $passwordFromDB);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		if (password_verify($password, $passwordFromDB)) {
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['secretnumber'] = sprintf("%09d", rand(0, 999999999));
		} else {
			$message = "Wrong username and password!";
		}
	}
	mysqli_close($link);
}
if (isset($_SESSION['loggedin'])){
	header ( "location: secretpage.php" );
	exit ();
}
if (isset($_SESSION['loggedout'])) {
	$message = "You have been logged out.";
	unset ( $_SESSION ['loggedout'] );
}
?>
<!doctype html>
<html>
<head>
<title>Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="PHP login form">
<meta name="author" content="Marcus Kivi">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="login-form">
    <form method="post">
        <h2 class="text-center">Log in</h2>
		<?php $message and printf("<p class='alert-warning'>%s</p>",$message) ?>
        <div class="form-group" tooltip="username: pekka">
            <input type="text" class="form-control" placeholder="Username" autofocus="autofocus" name="username" required="required" value="<?php print(htmlentities($_SESSION['username'], ENT_QUOTES, "UTF-8"));?>">
        </div>
        <div class="form-group" tooltip="password: asdf2">
            <input type="password" class="form-control" placeholder="Password" name="password" required="required">
        </div>
        <div class="form-group">
            <input type="submit" name="loginButton" class="btn btn-primary btn-block" value="Log in">
        </div>  
    </form>
</div>
</body>
</html>
