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
if(empty($_POST['ser'])){
	echo "no";
}
else{
	$id = $_POST['ser'];
	require("../dbconn.php");
	$stmt = $conn->prepare("SELECT * FROM $photos WHERE uploader = ? AND id = ?");
	$stmt->bindValue(1, $uname);
	$stmt->bindValue(2, $id);
	$stmt->execute();
	
	$numrows = $stmt->rowCount();
	if($numrows == 1){
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$filepath = $row['filepath'];
		$stmt = $conn->prepare("DELETE FROM $photos WHERE id = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		
		$stmt = $conn->prepare("SELECT * FROM $photos WHERE uploader = ? AND id = ?");
		$stmt->bindValue(1, $uname);
		$stmt->bindValue(2, $id);
		$stmt->execute();
		
		$stmt = $conn->prepare("DELETE FROM $comments WHERE postid = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		
		if(!unlink($filepath))
			echo "couldnt delete file ";
		
		
		$numrows = $stmt->rowCount();
		if($numrows == 0){
			header("location:../Users/profile.php");
		} else 
			echo "sometihng went wrong";		
		
	}
	$conn = null;	
}
?>