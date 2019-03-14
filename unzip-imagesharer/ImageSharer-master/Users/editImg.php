<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
if(!$uname)
		die ("* You must be logged in to change settings of a photo");
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
<body onload="setPri()">
<div class="main">
	<?php
	if(!empty($_GET['id'])){
		$id = $_GET['id'];
		require("../dbconn.php");
		$stmt = $conn->prepare("SELECT * FROM photos WHERE uploader = ? AND id = ?");
		$stmt->bindValue(1, $uname);
		$stmt->bindValue(2, $id);
		$stmt->execute();
	
		$numrows = $stmt->rowCount();
	
		if($numrows == 1){
			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo '<img name="imgPath" id="img" src="' . $result['filepath'] . '" />
			<span id="header">' . $result['filename'] . '</span>';
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$dbuploader = $row['uploader'];
			$dbprivate = $row['private'];
			$phid = $result['id'];
		
			}
		$conn = null;		
		
		}
		else
			echo "* No image was found";
	
		if($dbprivate == 1){
			?>
			<script>
			function setPri(){
				document.getElementById("pri").checked = true;
			}
			</script>
			<?php
		}
		else if($dbprivate == 0) {
			?>
			<script>
			function setPri(){
				document.getElementById("pub").checked = true;
			}
			</script>
			<?php
		}
	}
	else
		die ("Error: No image was selected");
	?>
	
	<!-- form to delete the image -->
	<form name="delForm" id="delForm" method="post" action="../Process/del.php">
		<input type="text" name="id" id="id" value="<?php echo $phid;?>">
		<button  id="delBtn" type="submit">Delete</button>
	</form>
	
	<!-- for changing the private setting -->
	<form name="priChg" id="priChg" method="POST" action="../Process/pri.php">
		<input type="radio" name="setter" id="pri" onclick="priClick()" value="Private">Private
		<input type="radio" name="setter" id="pub" onclick="pubClick()" value="Public">Public
		<input type="text" name="id" id="id" value="<?php echo $phid;?>" readonly>
		<button  id="priBtn" type="submit">Update</button>
	</form>
	
</div>
</body>
</html>