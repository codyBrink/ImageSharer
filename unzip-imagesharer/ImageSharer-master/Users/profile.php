<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
include_once("../hasher.php");
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$uavatar = $_SESSION['avatar'];
if(!$uname)
	die("You must be logged in to view your profile");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<link rel="stylesheet" href="../css/main.css">
</head>
<body>
<!-- div that displays the username -->
<div id="name">Hello <?php echo $uname;?></div>

<!-- the user's avatar image -->
<img id="avatar" onclick="profile()" alt="Avatar" src="../<?php echo $uavatar;?>">

<!-- div that holds the links -->
<div id="links">

	<!-- start of buttons to show when the mouse leaves the "links" div -->
	<a id="editAva2" class="btn btn-info btn-lg">
	<span id="editAvaIcon" class="glyphicon glyphicon-pencil"></span>
	</a>
	
	<a id="fileUp2" class="btn btn-info btn-lg">
	<span id="fileUpIcon" class="glyphicon glyphicon-export"></span>
	</a>
	
	<a id="index2" href="../index.php" class="btn btn-info btn-lg">
	<span id="indexIcon" class="glyphicon glyphicon-globe"></span>
	</a>
	
	<a id="pswdChg2" class="btn btn-info btn-lg">
	<span id="pswdChgIcon" class="glyphicon glyphicon-edit"></span>
	</a>
	
	<a id="logout2" href="../Process/logout.php" class="btn btn-info btn-lg">
	<span  id="logoutIcon" class="glyphicon glyphicon-log-out"></span>
	</a>
	<!-- end of buttons to show when mouse leaves the "links" div -->

	<!-- "edit avatar" button -->
	<a id="editAva" class="btn btn-info btn-lg">
	<span class="glyphicon glyphicon-pencil"></span> edit avatar
	</a>
	
	
	<!-- "upload photo" button -->
	<a id="fileUp" class="btn btn-info btn-lg">
	<span class="glyphicon glyphicon-export"></span> Upload photo
	</a>
	
	
	<!-- "home page" button -->
	<a id="index" href="../index.php" class="btn btn-info btn-lg">
	<span class="glyphicon glyphicon-globe"></span> Home Page
	</a>
	
	
	<!-- "change password" button -->
	<a id="pswdChg" class="btn btn-info btn-lg">
	<span class="glyphicon glyphicon-edit"></span> change password
	</a>
	
	<!-- "logout" button -->
	<a id="logout" href="../Process/logout.php" class="btn btn-info btn-lg">
	<span class="glyphicon glyphicon-log-out"></span> Logout
	</a>

</div>
<!-- end of "links" div -->

<!-- div that holds the main content -->
<div id="profileMain">
	<h2>Your photos:</h2>
	<!-- div that holds the images -->
	<div id="photos">
	<?php
	include_once("../dbconn.php");
	$stmt = $conn->prepare("SELECT * FROM photos WHERE uploader = ?");
	$stmt->bindValue(1, $uname);
	$stmt->execute();

	$numrows = $stmt->rowCount();

	if ($numrows != 0){
		while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
			//displays all the images that the specific user has uploaded
			echo '<a href="editImg.php?id=' . $result['id'] . '"><img name="userImg" id="userImg" alt="User image" src="' . $result['filepath'] . '" /></a>
			<span id="imgTitle">' . $result['filename'] . '</span>';
		}
	}
	else 
		echo "you have no images. click 'upload photo' button to start uploading!";
	$conn = null;
?>
	</div>
	<!-- end of the "photos" div -->
	
</div>
<!-- end of the "main" div -->
</body>
</html>