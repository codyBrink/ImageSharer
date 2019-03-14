<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$dbuploader = $_SESSION['uploader'];
$uavatar = $_SESSION['avatar'];
$name = $_SESSION['filename'];
$fid = $_SESSION['fid'];
$add = $_SESSION['added'];
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
<script src="../js/main.js"></script>
</head>
<body>
<!-- div that holds the back button -->
<div id="navBar">
	<a id="bckSrh" href="search.php" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-arrow-left"></span> Back to Search</a>
	<?php
	//displays a button to goto profile IF a username is present
	if ($uname)
		echo '<a id="profile" href="../Users/profile.php" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-home"></span> Profile</a>';
	?>
	</div>

<!-- div that contains all the content -->
<div class="main">
	<?php
	function sanitize_data($data){
		$data = htmlspecialchars($data);
	
		return $data;
	}


	//gets the id of the image from the url
	if(!empty($_GET['id'])){
		$fid = $_GET['id'];
		$_SESSION['fid'] = $fid;
	}	
	else 
		die("no image was given. Please try again");
	
	
	require("../dbconn.php");
	//prepared statement to help prevent SQL Injection
	$stmt = $conn->prepare("SELECT * FROM photos WHERE id = ? AND private = ?");
	$stmt->bindValue(1, $fid);
	$stmt->bindValue(2, 0);
	$stmt->execute();
	
	$numrows = $stmt->rowCount();
	
	if($numrows == 1){
		//takes the data returned and places it in a associative array
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$fid = $result['id'];
		$uploader = $result['uploader'];
		$added = $result['added'];
		$fname = $result['filename'];
		$fpath = $result['filepath'];
		//gets the year, month, and date only
		$fxDate = substr($added, 0, 10);
		//gives the data of the current image to the seesion variables 
		$_SESSION['fid'] = $fid;
		$_SESSION['added'] = $fxDate;
		$_SESSION['uploader'] = $result['uploader'];
		$id = $_SESSION['id'];
		$add = $_SESSION['added'];
		
	}
	else
		header("location:search.php");
	
	?>
	
	<!-- displays the image along with its data (date added, name, uploader) -->
	<h3 id="titleBanner"><?php echo $fname; ?></h3>
	<img  id="selectedImg" src="<?php echo $fpath;?>" alt="Selected Image">
	<span id="uploader">Uploaded by: <a href="viewUser.php?user=<?php echo $uploader;?>"><?php echo $uploader;?></a></span>
	<span id="added">Added on: <?php echo $add;?></span>
	</div>
	
<!-- div that contains the comments -->
<div id="comments">
	<?php
	//IF the user is NOT logged in will display the below message.
	//if they are then the form for submitting comments will appear
	if (!$uname){
		echo "<font color='red'>You must be logged in to make a comment. <a href='../index.php'>
		click here</a> to goto the home page and log in</font>";
	} else {
		echo '<form id="cmtForm" method="post" action="../Process/mkcmt.php">
		<img id="loggedAva" src="../' . $uavatar . '">
		<textarea id="comment" name="comment" placeholder="add a comment" required>
		</textarea>
		<input type="submit" id="addCmt" value="add"></input>
		</form>';
	}
	?>

	<hr>
	<?php
	//gets all the comments related to the image
	$stmt = $conn->prepare("SELECT * FROM comments where postid = ? ORDER BY added DESC");
	$stmt->bindValue(1, $fid);
	$stmt->execute();
	
	$numrows = $stmt->rowCount();
	
	if($numrows != 0){
		while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$dbCmtr = $result['commenter'];
			//IF the username matches any of the commenters 
			//it will display the option to delete the comment "X"
			if($dbCmtr === $uname){
			//the comments themselves are sanitized to prevent various injections (XSS, HTML)
			echo '<br>
			<form class="delFrm" method="post" action="../Process/delcmt.php">
			<img class="cmtrAvatar" src="../' . $result['cmavatar'] . '">
			<span id="cmtid">' . $result['id'] . '</span>
			<a class="cmtr" href="viewUser.php?user=' . $result['commenter'] . '">' . $result['commenter'] . '</a>
			<span class="cmtDate">added: ' . $result['added'] . '</span>
			<p class="msg">' . sanitize_data($result['comment']) . '</p>
			<input type="text" class="cmtid" name="cmtid" readonly></input>
			<button type="submit" class="delCmt" name="delCmt">X</button>
			</form>';
			} else {
			echo '<br> 
			<img class="cmtrAvatar" src="../' . $result['cmavatar'] . '">
			<a class="cmtr" href="viewUser.php?user=' . $result['commenter'] . '">' . $result['commenter'] . '</a>
			<span class="cmtDate">added: ' . $result['added'] . '</span>
			<p class="msg">' . sanitize_data($result['comment']) . '</p>';
			}
		}
		
	}
	
$conn = null;
?>
</div>
<!-- end of "main" div -->

</body>
</html>