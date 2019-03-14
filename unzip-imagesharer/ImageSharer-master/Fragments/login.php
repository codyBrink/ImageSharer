<form method="post"  id="lgFrm" action="Process/login.php" role="form">
	<span id="err"></span>
	<div id="user-group" class="form-group">
		<label id="userLabel">Username:</label>
		<input type="text" class="form-control" name="username" id="username">
	</div>
	
	<div id="pswd-group" class="form-group">
		<label id="pswdLabel">Password:</label>
		<input type="password" class="form-control" name="pswd" id="pswd">
	</div>
	<button type="submit" name="logInBtn" id="logInBtn" class="btn btn-default">
	<span class="glyphicon glyphicon-log-in"></span> Log-in</button>
</form>
	<br>
	<button id="signBtn" type="button" class="btn btn-default">
	<span class="glyphicon glyphicon-th-list"></span> Sign-up</button>

	<button  id="contBtn" type="button" class="btn btn-default">
	<span class="glyphicon glyphicon-envelope"></span> Contact Me</button>