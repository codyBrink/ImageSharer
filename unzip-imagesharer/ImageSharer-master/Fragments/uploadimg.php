	<form method='post' action="../Process/uploadimg.php" id="uploadImg" enctype='multipart/form-data'>
	<h2 id="uploadBanner">Upload a photo</h2>
	<br><br>
	<span id="uploadErr"></span>
	<input type='file' name='ourFile' />
	<br><br>
	<div class="radio">
	<span><input type="radio" name="setter" id="pri" value="Private">Private</span>
	</div>
	<div class="radio">
	<label id="pubLabel"><input type="radio" name="setter" id="pub" value="Public">Public</label>
	<br>
	<input type='submit' id="uploadBtn" value='upload image' name='upload'>
	<p id="priMsg">Note: When you set a image to "Private" it will
	not show up in searches or when others view your profile.</p>
	</form>
</div>