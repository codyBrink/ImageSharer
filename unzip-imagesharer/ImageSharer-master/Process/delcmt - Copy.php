<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
include_once("../hasher.php");
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$userid = $_SESSION['id'];
$dbuploader = $_SESSION['uploader'];
$uavatar = $_SESSION['avatar'];
?>

<?php
	$id = $_POST['cmtid'];
	
	require("../dbconn.php");
	$stmt = $conn->prepare("SELECT * FROM $comments WHERE id = ? AND commenter = ?");
	$stmt->bindValue(1, $id);
	$stmt->bindValue(2, $uname);
	$stmt->execute();
	
	$numrows = $stmt->rowCount();
	
	if($numrows == 1){
	
	$stmt = $conn->prepare("DELETE FROM $comments WHERE id = ?");
	$stmt->bindValue(1, $id);
	$stmt->execute();
		
	header('Location: ' . $_SERVER['HTTP_REFERER']);
			
	$conn = null;
	
	}
	else
		echo "* Error: comment was not found";
	

?>