
<?php
	unset($_COOKIE['access-token']);
	setcookie('access-token', null, -1, '/');
	header("Location: index.php"); /* Redirect browser */
	exit();

?>