<?php
//Welcome to Image Sharer!!!!...
//a photo-sharing web application 
//made by Cody Brink
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$uname = $_SESSION['username'];
$uavatar = $_SESSION['avatar'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <link rel="stylesheet" href="css/main.css">
</head>
<body id="homePage">
	<div id="wrapper">
	<!-- div for top part of index page -->
	<div class="container-fluid bg-1 text-center">
		<h3>Hello and welcome to <span id="logo">Image Sharer</span></h3>
		<form name="serForm" method="get" action="Search/search.php" role="form">
		<input class="form-control" id="indexSerBar" name="serBar" type="text" placeholder="Search for photos"  required />
		<button type="submit" id="indexSerBtn" name="serBtn" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> Search</button>
		</form>
	<!-- end of top div tag -->
	</div>
	
<?php	
	//outputs form for loging in and signing up
	$form = '<div id="bottom" class="container-fluid bg-2 text-center">
			<h3 id="logLabel">Have an Account?</h3>
			<button  id="logBtn" type="button" class="btn btn-default">
			<span class="glyphicon glyphicon-user"></span> Log-in</button>
			<h3 id="signLabel">Create an account:</h3>
			<button  id="signBtn" type="button" class="btn btn-default">
			<span class="glyphicon glyphicon-th-list"></span> Sign-up</button>
			<h3 id="contactLabel">Visit the Developer:</h3>
			<button  id="contBtn" type="button" class="btn btn-default">
			<span class="glyphicon glyphicon-envelope"></span> Contact Me</button>
	
		</div>';
		
	//is outputted if the user is logged in 
	$isLogged = '<div id="bottom_2" class="container-fluid bg-2 text-center">
	<span id="userLab">Hello ' . $uname . '</span>
	<div id="userData">
		<img id="userAvatar" onclick="profile()" class="img-circle" src="' . $uavatar . '" />
		<a href="Process/logout.php"><button onclick="logout()" type="button" id="logoutBtn" class="btn btn-default">Logout</button></a>
		<a href="Users/profile.php"><button type="button" id="profileBtn" class="btn btn-default">Profile</button></a>
	</div>
	</div>';
	
	
//if no user is logged in hide the user options and display
//options for loging in and signing up	
if (!$uname){
	echo $form;
	
}
else //display if the user is logged in
	echo $isLogged;
?>
</body>
</html>
