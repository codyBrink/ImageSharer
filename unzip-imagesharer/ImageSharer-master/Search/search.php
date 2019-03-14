<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$_SESSION['id'] = "";
$dbuploader = $_SESSION['uploader'];
$uavatar = $_SESSION['avatar'];
$_SESSION['added'] = "";
$srh = $_SESSION['srh'];
?>

<?php
//checks to see if the search form field is empty
if(!empty($_GET['serBar'])){
	//extracts the data that the user entered
	$search = $_GET['serBar'];
	$_SESSION['srh'] = $search;
	
}
else if ($srh){
	//if the search form is empty then used whats in the session variable
	$search = $srh;
}
else
	//if both are empty. display error message
	$err = "You didnt type anything";
	


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
<style>
</style>
</head>
<body>

<!--form for search bar -->
<form id="serFrm" name="serForm" method="get" action="search.php" role="form">
	<input class="form-control" id="serBar" name="serBar" type="text" placeholder="Search for photos" value="<?php echo $search;?>" required />
	<button type="submit" id="serBtn" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> Search</button>
</form>

<!-- div for our main content such as images. -->
<div class="main">
	<?php
	//uses the db connection file
	require("../dbconn.php");
	//prepared statement to help prevent SQL injections
	$stmt = $conn->prepare("SELECT * FROM photos WHERE filename REGEXP ? AND private = ?");
	$stmt->bindValue(1, $search);
	$stmt->bindValue(2, 0);
	$stmt->execute();

	$numrows = $stmt->rowCount();

	if($numrows != 0){
		while($result = $stmt->fetch(PDO::FETCH_BOTH)){
			//places all the images and their information into set divs
			echo '<div class="results">
			<a href="viewImg.php?id=' . $result['id'] . '"><img class="resultImg" src="' . $result['filepath'] . '" /></a>
			<span class="resultTitle">' . $result['filename'] . '</span>
			<h5 class="uploader"> Uploader: ' . $result['uploader'] . '</h5>
			</div>';
		}
	} else
		$err = "* sorry but there are no images matching your search";
		//kills connection to db
		$conn = null;
	?>
<!-- end of "main" div -->
</div>
<!-- used to display any error messages -->
<span id="serErr"><?php echo $err;?></span>
</body>
</html>