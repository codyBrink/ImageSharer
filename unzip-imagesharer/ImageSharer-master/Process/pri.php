<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$userid = $_SESSION['id'];
$dbuploader = $_SESSION['uploader'];
$uavatar = $_SESSION['avatar'];
?>

<?php
$set = 0;
if(!empty($_POST['id'])){
	$id = $_POST['id'];
	$rad = $_POST['setter'];
	if($rad === "Private")
		$set = 1;
	else {
		$set = 0;
	}
	require("../dbconn.php");
	$stmt = $conn->prepare("UPDATE $photos SET private = ? WHERE id = ?");
	$stmt->bindValue(1, $set);
	$stmt->bindValue(2, $id);
	$stmt->execute();
	header("location:../Users/profile.php");
	
	$conn = null;
}
?>