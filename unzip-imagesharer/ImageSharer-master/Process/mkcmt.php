<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$fid = $_SESSION['fid'];
$uavatar = $_SESSION['avatar'];
?>

<?php 
function sanitize_data($data){
	$data = htmlspecialchars($data);
	
	return $data;
}

if(!empty($_POST['comment'])){
		$comment = sanitize_data($_POST['comment']);
		$phid = $_POST['postid'];
		$cmtr = $uname;
		$ava = $uavatar;
		if ($cmtr === $uname){
			require("../dbconn.php");
			//inserts the data into the "comments" table
			$stmt = $conn->prepare("INSERT INTO $comments (commenter, cmavatar, comment, postid)
			VALUES (?, ?, ?, ?)");
			$stmt->bindValue(1, $cmtr);
			$stmt->bindValue(2, $ava);
			$stmt->bindValue(3, $comment);
			$stmt->bindValue(4, $fid);
			$stmt->execute();
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			$conn = null;
		} else
			echo "* Access Denied: Username did not match the current user. Nice try";
	}
	else
		echo "* Comments can not be empty";
	

?>