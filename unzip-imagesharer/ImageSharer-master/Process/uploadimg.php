<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$id = $_SESSION['id'];
$dbuploader = $_SESSION['uploader'];
$uavatar = $_SESSION['avatar'];
?>

<?php
if ($uname){
	if(isset($_POST['upload'])){
		//gets the value of the radio buttons 
		//any checks if one of them were checked
		$rad = $_POST['setter'];
		if ($rad === 'Private'){
			$set = 1;
		} else if ($rad === 'Public'){
			$set = 0;
		}
		else
			$set = 0;
		
		//the target directory
		$tar_dir = "../Users/Users/" . $uname . "/photos/";
		$filetmp = $_FILES["ourFile"]["tmp_name"];
		$filename = $_FILES["ourFile"]["name"];
		$filetype = $_FILES["ourFile"]["type"];
		$filepath = $tar_dir . $filename;
		//gets the name of the file
		$fxfilename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
		
		//checks to see if the file is an image
		$check = getimagesize($_FILES["ourFile"]["tmp_name"]);
		if($check !== false){
			//checks if image is larger than 1 MB
			if($_FILES["ourFile"]["size"] <= 1048576){
		
					//tries to save image to local file system
					if(move_uploaded_file($filetmp,$filepath)){
		
						require("../dbconn.php");
						$stmt = $conn->prepare("SELECT * FROM $photos");
						$stmt->execute();
					
						$numrows = $stmt->rowCount();
						
						if($numrows != 0){
					
						$stmt = $conn->prepare("INSERT INTO $photos (uploader, filepath, filename, private)
						VALUES (?, ?, ?, ?)");
						$stmt->bindValue(1, $uname);
						$stmt->bindValue(2, $filepath);
						$stmt->bindValue(3, $fxfilename);
						$stmt->bindValue(4, $set);
						$stmt->execute();
		
						$conn = null;
		
						header("location:../Users/profile.php");
						
						}
						else
							echo "* could not reach database. Please try again";
		
					}
					else
						echo "* there was an error. Image not saved";
			
				}
				else
					echo "* Images can not be larger than 1 MB";
			
			}
			else
				echo "* file was not an image";
		
		}
		else
			echo "* you did not select a image";
		
	}
	else
		echo "* you must be logged in to upload images";
	

?>