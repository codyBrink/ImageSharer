<?php
//first two lines for preventing "document expired" error.
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
require("../hasher.php");
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$id = $_SESSION['id'];
$dbuploader = $_SESSION['uploader'];
$uavatar = $_SESSION['avatar'];
?>

<?php
	if($_POST['curPass']){
		$curPass = $_POST['curPass'];
		if($_POST['newPass']){
			$newPass = $_POST['newPass'];
			if($_POST['conPass']){
				$conPass = $_POST['conPass'];
				if($newPass === $conPass) {
					$hashedCurPass = cryptData($curPass);
					$hashedNewPass = cryptData($conPass);
					require("../dbconn.php");
					$stmt = $conn->prepare("SELECT * FROM $users WHERE username = ? AND password = ?");
					$stmt->bindValue(1, $uname);
					$stmt->bindValue(2, $hashedCurPass);
					$stmt->execute();
					
					$numrows = $stmt->rowCount();
					
					if ($numrows == 1){
						$stmt = $conn->prepare("UPDATE $users SET password = ? WHERE username = ?");
						$stmt->bindValue(1, $hashedNewPass);
						$stmt->bindValue(2, $uname);
						$stmt->execute();
						
						$stmt = $conn->prepare("SELECT * FROM $users WHERE username = ? AND password = ?");
						$stmt->bindValue(1, $uname);
						$stmt->bindValue(2, $hashedNewPass);
						$stmt->execute();
						
						$numrows = $stmt->rowCount();
						
						if ($numrows == 1){
							header("location:../Process/logout.php");
						}
						else
							echo "* An error occured. Try again.";
					}
					else 
						echo "* your current password did not match our records";
					
					$conn = null;
				}
				else 
					echo "* your new passwords did not match";
			}
			else
				echo "* please confirm your new password";
			
		}
		else
			echo "* please enter a new password";
	}
	else
		echo "* please enter you current password";

	
?>