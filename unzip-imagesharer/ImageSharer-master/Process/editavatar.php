<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$uavatar = $_SESSION['avatar'];
?>

<?php
if ($uname){
	//if the submitted a image...
	if($_POST['avaUpload']){
		$tar_dir = "Users/Users/" . $uname . "/avatar/";
		$filetmp = $_FILES["ourFile"]["tmp_name"];
		$filename = $_FILES["ourFile"]["name"];
		$filetype = $_FILES["ourFile"]["type"];
		$imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
		$filepath = $tar_dir . $filename;
		
		//ensures the file that was placed was an image
		$check = getimagesize($_FILES["ourFile"]["tmp_name"]);
		 if($check !== false){
			//checks to see if the image was larger than 1 MB
			if($_FILES["ourFile"]["size"] <= 1048576){
					//checks to see if the user's current avatar is the default image
					//if it is than no file file will be deleted
					if($uavatar !== "defaultUser.jpg")
							//checks to see if it deleted the old user avatar from 
							//local file system
							if(!unlink('../' . $uavatar))
								echo "* couldnt delete cold file";
		
			require("../dbconn.php");
			$stmt = $conn->prepare("UPDATE $users SET avatar = ? WHERE username = ?");
			$stmt->bindValue(1, $filepath);
			$stmt->bindValue(2, $uname);
			$stmt->execute();
		
			//checks to see if the file was saved to local file system
			if(move_uploaded_file($filetmp, '../' . $filepath)){
				$stmt = $conn->prepare("SELECT * FROM $users WHERE username = ?");
				$stmt->bindValue(1, $uname);
				$stmt->execute();
			
				$numrows = $stmt->rowCount();
			
				if($numrows == 1){
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					$dbavatar = $row['avatar'];
					$_SESSION['avatar'] = $dbavatar;
					$uavatar = $_SESSION['avatar'];
					//updates the comments table as well
					$stmt = $conn->prepare("UPDATE $comments SET cmavatar = ? WHERE commenter = ?");
					$stmt->bindValue(1, $dbavatar);
					$stmt->bindValue(2, $uname);
					$stmt->execute();
					
					header("location:../Users/profile.php");
				}
				else 
					echo "* something happednc couldnt comnect to db";
				
			}
			else
				echo "* something went wrong";
		
		$conn = null;
			 }
			 else
				 echo "* file too large";
		
		 }
		 else
			 echo "* file was not a image";
		
		}
		else
			echo "* please select a image";
		
	}
	else 
		echo "* you must be logged into your account to upload a new avatar";
 
?>