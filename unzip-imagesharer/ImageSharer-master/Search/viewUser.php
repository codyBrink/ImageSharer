<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$id = $_SESSION['id'];
$dbuploader = $_SESSION['uploader'];
$uavatar = $_SESSION['avatar'];
$uploader = $_SESSION['uploader'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/main.css">
</head>
<body>
<?php

//gets the username from the URL
if(!empty($_GET['user'])){
	$upLoader = $_GET['user'];
} else {
	die ("* No user data was found");
}
	
		
	require("../dbconn.php");
	$stmt = $conn->prepare("SELECT * FROM $users WHERE username = ?");
	$stmt->bindValue(1, $upLoader);
	$stmt->execute();
	
	$numrows = $stmt->rowCount();
	
	if($numrows == 1){
		$row = $stmt->fetch(PDO::FETCH_BOTH);
		$user = $row['username'];
		$avatar = $row['avatar'];
		
	} else
		echo "* No data was found";
	
	
	
	$conn = null;

?>
<div id="name">
	<?php echo $user;?>
</div>
<div id="avatar">
	<img  id="avatar" src="../<?php echo $avatar;?>">
</div>
<div class="main">
	<h2 id="phHdr"><?php echo $user;?>'s Photos:</h2>
	<?php
	require("../dbconn.php");
	$stmt = $conn->prepare("SELECT * FROM $photos WHERE uploader = ? AND private = ?");
	$stmt->bindValue(1, $upLoader);
	$stmt->bindValue(2, 0);
	$stmt->execute();

	$numrows = $stmt->rowCount();
	
	//if any photos were found that are set to public...
	if($numrows != 0){
		while($result = $stmt->fetch(PDO::FETCH_BOTH)){
			echo '<a href="viewImg.php?id=' . $result['id'] . '"><img name="userImg" id="userImg" id="Users image" src="' . $result['filepath'] . '" /></a>
			<span id="imgTitle">' . $result['filename'] . '</span>';
		} 
		
	} else
		echo "the user does not have any photos";


	$conn = null;
?>
</div>
</body>
</html>