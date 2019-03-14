<form role="form" id="signFrm" method="post" action="Process/signup.php">
	
	<span id="err"></span>
	<div class="form-group">
		<label id="newUserLabel">Username:</label>
		<input type="text" class="form-control" name="newUsername" id="newUsername">
	</div>
	<div class="form-group">
		<label id="emailLabel">Email:</label>
		<input type="email" class="form-control" name="email" id="email">
	</div>
	<div class="form-group">
		<label id="passLabel">Password:</label>
		<input type="password" class="form-control" name="pass" id="pass">
	</div>
	<div class="form-group">
		<label id="conPswdLabel">Confirm Password:</label>
		<input type="password" class="form-control" name="conPswd" id="conPswd">
	</div>
		<button type="submit" name="signUpBtn" id="signUpBtn" class="btn btn-default"><span class="glyphicon glyphicon-floppy-saved"></span> Sign-up</button>
</form>
<br>
<button id="logBtn" type="button" class="btn btn-default">
<span class="glyphicon glyphicon-user"></span> Log-in</button>
<br>
<button id="contBtn" type="button" class="btn btn-default">
<span class="glyphicon glyphicon-envelope"></span> Contact Me</button>

