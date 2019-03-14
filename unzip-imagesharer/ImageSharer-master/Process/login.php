<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
include_once("../hasher.php");
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$userid = $_SESSION['id'];
$uavatar = $_SESSION['avatar'];

//function to sanitize data
function sanitize_data($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	
	return $data;
}

//if a username was entered
if ($_POST['username']){
	$user = sanitize_data($_POST['username']);
		if (!empty($_POST['pswd'])) {
			require("../dbconn.php");
			$pass = sanitize_data($_POST['pswd']);
			
			//prepared statement to help prevent SQL injections
			$stmt = $conn->prepare("SELECT * FROM $users WHERE username = ?");
			$stmt->bindValue(1, $user);
			$stmt->execute();
			
			$numrows = $stmt->rowCount();
			
			if ($numrows == 1) {
				//takes the data retrieved and turns it into a associative array
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$dbid = $row['id'];
				$dbuser = $row['username'];
				$dbpass = $row['password'];
				//encrypts the password with method inside "hasher.php"
				$nupass = cryptData($pass);
				$dbactive = $row['active'];
				$dbavatar = $row['avatar'];
						if($nupass == $dbpass){
							if ($dbactive == 1){
								$_SESSION['username'] = $dbuser;
								$_SESSION['id'] = $dbid;
								$_SESSION['avatar'] = $dbavatar;
								echo 1;
							}
							else
								echo "* You must confirm your email";
						}
						else
							echo "* The password you entered did not match thr username";
				
			}
			else 
				echo "* The username that you entered was not found";
			
		$conn = null;	
		}
		else 
			echo "* Please enter a password";
		
		
} 
else
	echo "* Please enter a username";

?>