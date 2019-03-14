<?php
include_once("../hasher.php");
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];

//function to sanitize data 
function sanitize_data($data){
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		
		return $data;
	}

//if the user isn't logged into a account
if(!$uname){
	if (!empty($_POST['newUsername'])) {
		$user = sanitize_data($_POST['newUsername']);
		if (!empty($_POST['email'])){
			$email = sanitize_data($_POST['email']);
			if (!empty($_POST['pass'])){
				$pswd = sanitize_data($_POST['pass']);
				if (!empty($_POST['conPswd'])){
					$conpswd = sanitize_data($_POST['conPswd']);
					if($pswd === $conpswd){
						if(filter_var($email, FILTER_VALIDATE_EMAIL)){
							//regular expression to check for the allowed rules
							if(preg_match("/^[a-zA-Z_]*$/",$user)) {
								require("../dbconn.php");
								//prepared statements to help prevent SQL injection
								$stmt = $conn->prepare("SELECT * FROM $users WHERE username = ?");
								$stmt->bindValue(1, $user);
								$stmt->execute();
								
								$numrows = $stmt->rowCount();
								
								//if the data entered does not return a row from the table
								if($numrows == 0){
									$stmt = $conn->prepare("SELECT * FROM $users WHERE email = ?");
									$stmt->bindValue(1, $email);
									$stmt->execute();
									
									$numrows = $stmt->rowCount();
									
									if($numrows == 0){
										//uses the method inside "hasher.php" to encrypt the password
										$nupswd = cryptData($pswd);
										$code = rand();
										$stmt = $conn->prepare("INSERT INTO $users (username, email, password, code)
										VALUES (?, ?, ?, ?)");
										$stmt->bindValue(1, $user);
										$stmt->bindValue(2, $email);
										$stmt->bindValue(3, $nupswd);
										$stmt->bindValue(4, $code);
										$stmt->execute();
										
										//checks if the username was inserted
										$stmt = $conn->prepare("SELECT * FROM $users WHERE username = ?");
										$stmt->bindValue(1, $user);
										$stmt->execute();
										$numrows = $stmt->rowCount();
										if($numrows == 1){
											//webmaster sending email
											$site = "http://localhost/imagesharer";
											$webmaster = "Cody <codyjustinbrink@gmail.com>";
											$headers = "From: $webmaster";
											$subject = "Activate Your Account";
											$msg = "Thank you for signing up for Image Sharer \n";
											$msg .= "Below is a link to activate your account\n";
											$msg .= "$site/activate.php?user=$user&code=$code";
										
											//php mail function lets us send mail
											if(mail($email, $subject, $msg, $headers)){
												echo "an email has been sent";
												$user = "";
												$email = "";
												echo 1;
											}
											else 
												echo "* couldn't send email please try again";
										
										
											
										}
										else
											echo "* an error has occured. User account not crreated";
										
									}
									else
										echo "* the email is already taken";
								
								}
								else 
									echo "* username already exists";
								
								$conn = null;
							}
							else
								echo "* username can only contain letters and underscores";
						}
						else 
							echo "* please enter a valid email";
						
					}
					else
						echo "* your passwords did not match";
				}
				else
					echo "* Please confirm your password";
				
			}
			else
				echo "* Please enter a password";
		}
		else
			echo "* Please enter a email";
	}
	else
		echo "* Please enter a username";
	
}
else
	echo "* you are logged in alrdy";

?>