<?php
include_once("hasher.php");
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$userid = $_SESSION['id'];
$dbuploader = $_SESSION['uploader'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
#user, #code {
	display: none;
}
body {
	background-color: #80000B;
}
#main {
	position: relative;
	background-color: #474e5d;
	height: 400px;
	width: 650px;
	left: 190px;
	top: 70px;
	color: white;
	
}
</style>
<script>
function sub(){
document.getElementById('ourform').submit();
}
</script>
</head>
<body onload="sub()">
<?php
//gets the username from the url from the reg link
$user = $_GET['user'];
$code = $_GET['code'];

$form = "<div id='main'>
<form method='post' name='ourForm' id='ourForm' action='activate.php'>
<input type='text'  id='user' name='user' value='$user'>
<br>
<input type='text'  id='code' name='code' value='$code'>
<br>
<input type='submit' value='submit' name='actBtn'>


</form>
</div>";
if($_POST['actBtn']){
	$getUser = $_POST['user'];
	$getCode = $_POST['code'];
	
	if($getUser){
		if($getCode){
			require("dbconn.php");
			
			$stmt = $conn->prepare("SELECT * FROM $users WHERE username = ?");
			$stmt->bindValue(1, $getUser);
			$stmt->execute();
			
			$numrows = $stmt->rowCount();
			
			if($numrows == 1){
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$dbactive = $row['active'];
				$dbcode = $row['code'];
				if($dbactive == 0){
					$yes = 1;
					if($dbcode == $getCode){
						$stmt = $conn->prepare("UPDATE $users SET active= ? WHERE username = ?");
						$stmt->bindValue(1, $yes);
						$stmt->bindValue(2, $getUser);
						$stmt->execute();
						if(mkdir("Users/Users/" . $getUser . "/photos", 0777, true)){
							if(mkdir("Users/Users/" . $getUser . "/avatar", 0777, true)){
								header("location:index.php");
							}
							else
								echo "couldnt create avatar folder";
						}
						else
							echo "couldnt create photo folder";
						
						
					}
					else
						echo "invalid code...contact an admin";
				}
				else
					echo "your account is already active";
			}
			else
				echo "the username is not inside the db";
			
			$conn = null;
		}
		else
			echo "you must enter uor code";
	}
	else
		echo "you must enter the username you want to activate";
}
else 
	echo $form;
?>
</body>
</html>