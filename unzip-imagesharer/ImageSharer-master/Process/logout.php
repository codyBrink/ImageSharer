<?php
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$userid = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Logout Page</title>
</head>
<body>
<?php
if ($uname) {
	session_destroy();
	header("location:../index.php");
}
else
?>
</body>
</html>